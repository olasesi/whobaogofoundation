<?php
/**
 * Inline Image Upload Handler (IMPROVED)
 * 
 * Handles image uploads for inline content images (blog post body)
 * Used by the post editor's image insert feature
 * 
 * NEW: Also logs images to the media table for tracking
 * 
 * Returns JSON with:
 * {
 *   "success": true,
 *   "url": "/assets/images/uploads/2024-02-25/filename.jpg",
 *   "filename": "filename.jpg",
 *   "media_id": 123
 * }
 */

// Start session for admin check
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_id'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'error' => 'Unauthorized - must be logged in'
    ]);
    exit;
}

// Include database connection
require_once __DIR__ . '/../includes/db.php';

// Configuration
define('BASE_DIR', __DIR__ . '/../assets/images/uploads');
define('MAX_SIZE', 5242880); // 5MB
define('ALLOWED_TYPES', ['image/jpeg', 'image/png', 'image/webp', 'image/gif']);
define('ALLOWED_EXT', ['jpg', 'jpeg', 'png', 'webp', 'gif']);

/**
 * Generate unique filename
 */
function generateUniqueName($ext) {
    $timestamp = time();
    $random = bin2hex(random_bytes(4)); // 8 random hex characters
    return $timestamp . '-' . $random . '.' . $ext;
}

/**
 * Get image dimensions
 */
function getImageDimensions($filepath) {
    $size = @getimagesize($filepath);
    if ($size === false) {
        return ['width' => null, 'height' => null];
    }
    return [
        'width' => $size[0],
        'height' => $size[1]
    ];
}

/**
 * Validate uploaded file
 */
function validateFile($file) {
    // Check if file was uploaded
    if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
        return ['valid' => false, 'error' => 'No file provided'];
    }

    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errors = [
            UPLOAD_ERR_INI_SIZE => 'File exceeds upload_max_filesize',
            UPLOAD_ERR_FORM_SIZE => 'File exceeds form MAX_FILE_SIZE',
            UPLOAD_ERR_PARTIAL => 'File upload incomplete',
            UPLOAD_ERR_NO_FILE => 'No file uploaded',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary directory',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file',
            UPLOAD_ERR_EXTENSION => 'Upload blocked by extension'
        ];
        $message = $errors[$file['error']] ?? 'Unknown upload error';
        return ['valid' => false, 'error' => $message];
    }

    // Check file size
    if ($file['size'] > MAX_SIZE) {
        return ['valid' => false, 'error' => 'File size exceeds 5MB limit'];
    }

    // Check MIME type using finfo
    if (!function_exists('finfo_open')) {
        return ['valid' => false, 'error' => 'finfo extension not available'];
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mimeType, ALLOWED_TYPES)) {
        return ['valid' => false, 'error' => 'Invalid file type: ' . $mimeType . '. Allowed: JPG, PNG, WebP, GIF'];
    }

    // Check extension
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ALLOWED_EXT)) {
        return ['valid' => false, 'error' => 'Invalid file extension: .' . $ext];
    }

    return ['valid' => true];
}

/**
 * Handle the upload
 */
function handleUpload($pdo, $adminId) {
    // Check if image file was submitted
    if (!isset($_FILES['image'])) {
        return [
            'success' => false,
            'error' => 'No image file submitted'
        ];
    }

    $file = $_FILES['image'];

    // Validate file
    $validation = validateFile($file);
    if (!$validation['valid']) {
        return [
            'success' => false,
            'error' => $validation['error']
        ];
    }

    // Create date-based directory
    $dateFolder = date('Y-m-d');
    $uploadDir = BASE_DIR . '/' . $dateFolder;

    // Create directory if it doesn't exist
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0755, true)) {
            return [
                'success' => false,
                'error' => 'Failed to create upload directory. Check folder permissions.'
            ];
        }
    }

    // Verify directory is writable
    if (!is_writable($uploadDir)) {
        return [
            'success' => false,
            'error' => 'Upload directory is not writable. Check permissions.'
        ];
    }

    // Generate unique filename
    $originalName = basename($file['name']);
    $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
    $filename = generateUniqueName($ext);

    // Full path to save
    $uploadPath = $uploadDir . '/' . $filename;

    // Move uploaded file
    if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
        return [
            'success' => false,
            'error' => 'Failed to save file to server. Check folder permissions.'
        ];
    }

    // Set proper permissions
    chmod($uploadPath, 0644);

    // Get image dimensions
    $dimensions = getImageDimensions($uploadPath);

    // Return relative path for markdown
    $relativePath = 'uploads/' . $dateFolder . '/' . $filename;
    $publicUrl = '/assets/images/' . $relativePath;

    // Insert into media table for tracking
    try {
        $stmt = $pdo->prepare("
            INSERT INTO media (uploaded_by, file_name, file_path, file_url, file_type, file_size, width, height, alt_text)
            VALUES (:uploaded_by, :file_name, :file_path, :file_url, :file_type, :file_size, :width, :height, :alt_text)
        ");

        $stmt->execute([
            ':uploaded_by' => $adminId,
            ':file_name' => $originalName,
            ':file_path' => $uploadPath,
            ':file_url' => $publicUrl,
            ':file_type' => mime_content_type($uploadPath) ?: 'image/' . $ext,
            ':file_size' => filesize($uploadPath),
            ':width' => $dimensions['width'],
            ':height' => $dimensions['height'],
            ':alt_text' => pathinfo($originalName, PATHINFO_FILENAME)
        ]);

        $mediaId = $pdo->lastInsertId();
    } catch (Exception $e) {
        // Log to media table failed, but file was saved - still return success
        $mediaId = null;
    }

    return [
        'success' => true,
        'url' => $publicUrl,
        'filename' => $filename,
        'path' => $relativePath,
        'media_id' => $mediaId
    ];
}

// Process the upload
try {
    $response = handleUpload($pdo, $_SESSION['admin_id']);
} catch (Exception $e) {
    $response = [
        'success' => false,
        'error' => 'Server error: ' . $e->getMessage()
    ];
}

// Return JSON response
header('Content-Type: application/json; charset=utf-8');
http_response_code($response['success'] ? 200 : 400);
echo json_encode($response);
exit;