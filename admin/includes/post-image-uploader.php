<?php
/**
 * Post Images Upload Handler
 * 
 * Handles uploads for 5 post images (0-5 images per post)
 * Stores image paths in database as JSON array
 * 
 * Images stored at: /assets/images/post-images/YYYY-MM-DD/filename.jpg
 * (In root assets folder, NOT in admin assets)
 * 
 * Path explanation:
 * File location: /admin/includes/post-image-uploader.php
 * __DIR__ = /admin/includes
 * __DIR__ . '/../..' = /admin/includes/.. (admin) /.. (root)
 * __DIR__ . '/../../assets/images/post-images' = /assets/images/post-images
 */

class PostImageUploader {
    
    // Configuration - Goes OUT of admin to root assets
    // __DIR__/../../ = go out of includes, then out of admin to root
    private const BASE_DIR = __DIR__ . '/../../assets/images/post-images';
    private const MAX_SIZE = 5242880; // 5MB
    private const ALLOWED_TYPES = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    private const ALLOWED_EXT = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
    
    /**
     * Upload single post image
     * 
     * @param array $file $_FILES array element
     * @return array ['success' => bool, 'path' => string, 'url' => string, 'error' => string]
     */
    public static function upload(array $file): array {
        // Check if file was uploaded
        if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
            return ['success' => false, 'error' => 'No file provided'];
        }

        // Validate file
        $validation = self::validateFile($file);
        if (!$validation['valid']) {
            return ['success' => false, 'error' => $validation['error']];
        }

        // Create date-based directory
        $dateFolder = date('Y-m-d');
        $uploadDir = self::BASE_DIR . '/' . $dateFolder;

        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                return ['success' => false, 'error' => 'Failed to create upload directory'];
            }
        }

        if (!is_writable($uploadDir)) {
            return ['success' => false, 'error' => 'Upload directory not writable'];
        }

        // Generate unique filename
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $filename = self::generateUniqueName($ext);
        $uploadPath = $uploadDir . '/' . $filename;

        // Move uploaded file
        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            return ['success' => false, 'error' => 'Failed to save file'];
        }

        // Set proper permissions
        chmod($uploadPath, 0644);

        // Return relative and absolute paths
        $relativePath = 'post-images/' . $dateFolder . '/' . $filename;
        $publicUrl = '/assets/images/' . $relativePath;

        return [
            'success' => true,
            'path' => $relativePath,
            'url' => $publicUrl,
            'filename' => $filename
        ];
    }

    /**
     * Validate uploaded file
     */
    private static function validateFile(array $file): array {
        // Check for upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errors = [
                UPLOAD_ERR_INI_SIZE => 'File exceeds server limit',
                UPLOAD_ERR_FORM_SIZE => 'File exceeds form limit',
                UPLOAD_ERR_PARTIAL => 'Upload was interrupted',
                UPLOAD_ERR_NO_FILE => 'No file was uploaded',
                UPLOAD_ERR_NO_TMP_DIR => 'Server misconfiguration',
                UPLOAD_ERR_CANT_WRITE => 'Cannot write to disk',
            ];
            return ['valid' => false, 'error' => $errors[$file['error']] ?? 'Unknown error'];
        }

        // Check file size
        if ($file['size'] > self::MAX_SIZE) {
            return ['valid' => false, 'error' => 'File size exceeds 5MB limit'];
        }

        if ($file['size'] <= 0) {
            return ['valid' => false, 'error' => 'File is empty'];
        }

        // Check MIME type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        if (!$finfo) {
            return ['valid' => false, 'error' => 'Cannot verify file type'];
        }

        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, self::ALLOWED_TYPES)) {
            return ['valid' => false, 'error' => 'Invalid file type. Allowed: JPG, PNG, WebP, GIF'];
        }

        // Check extension
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, self::ALLOWED_EXT)) {
            return ['valid' => false, 'error' => 'Invalid file extension'];
        }

        return ['valid' => true];
    }

    /**
     * Generate unique filename
     */
    private static function generateUniqueName(string $ext): string {
        $timestamp = time();
        $random = bin2hex(random_bytes(4));
        return $timestamp . '-' . $random . '.' . $ext;
    }

    /**
     * Delete image by path
     * 
     * @param string $relativePath Path stored in database
     * @return bool Success
     */
    public static function deleteImage(string $relativePath): bool {
        if (empty($relativePath)) {
            return true;
        }

        if (strpos($relativePath, '..') !== false || strpos($relativePath, './') === 0) {
            return false;
        }

        // Go to root assets
        $fullPath = __DIR__ . '/../../assets/images/' . $relativePath;
        $realPath = realpath($fullPath);
        $baseRealPath = realpath(self::BASE_DIR);

        if (!$realPath || !$baseRealPath || strpos($realPath, $baseRealPath) !== 0) {
            return true; // File doesn't exist, that's ok
        }

        if (file_exists($realPath)) {
            if (!unlink($realPath)) {
                return false;
            }

            // Try to clean up empty date folder
            $dateFolder = dirname($realPath);
            if (is_dir($dateFolder) && count(scandir($dateFolder)) == 2) {
                @rmdir($dateFolder);
            }
        }

        return true;
    }

    /**
     * Delete all images for a post
     * 
     * @param array $images Array of image data from database
     * @return bool Success
     */
    public static function deleteAllImages(array $images): bool {
        $success = true;
        
        foreach ($images as $image) {
            if (isset($image['path'])) {
                if (!self::deleteImage($image['path'])) {
                    $success = false;
                }
            }
        }

        return $success;
    }
}

/**
 * Convenience function
 */
function deletePostImages(array $images): bool {
    return PostImageUploader::deleteAllImages($images);
}