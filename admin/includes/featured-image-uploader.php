<?php
/**
 * Featured Image Upload Handler
 * 
 * Handles image uploads with:
 * - Date-based folder organization
 * - Unique filename generation
 * - File validation
 * - Error handling
 * 
 * Usage:
 *   $result = uploadFeaturedImage($_FILES['featured_image']);
 *   if ($result['success']) {
 *       $imagePath = $result['path'];
 *       $imageFilename = $result['filename'];
 *   } else {
 *       $error = $result['error'];
 *   }
 */

class FeaturedImageUploader {
    
    // Configuration
    private const BASE_DIR = __DIR__ . '/../assets/images/featured-images';
    private const MAX_SIZE = 5242880; // 5MB
    private const ALLOWED_TYPES = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    private const ALLOWED_EXT = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
    
    /**
     * Upload featured image
     * 
     * @param array $file $_FILES array element
     * @return array ['success' => bool, 'path' => string, 'filename' => string, 'error' => string]
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

        // Generate unique filename
        $originalName = basename($file['name']);
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $filename = self::generateUniqueName($ext);

        // Full path to save
        $uploadPath = $uploadDir . '/' . $filename;

        // Move uploaded file
        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            return ['success' => false, 'error' => 'Failed to save file'];
        }

        // Set proper permissions
        chmod($uploadPath, 0644);

        // Return relative path for database storage
        $relativePath = 'featured-images/' . $dateFolder . '/' . $filename;

        return [
            'success' => true,
            'path' => $relativePath,
            'filename' => $filename,
            'dateFolder' => $dateFolder,
            'fullPath' => $uploadPath
        ];
    }

    /**
     * Validate uploaded file
     */
    private static function validateFile(array $file): array {
        // Check file size
        if ($file['size'] > self::MAX_SIZE) {
            return ['valid' => false, 'error' => 'File size exceeds 5MB limit'];
        }

        // Check MIME type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
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
     * Generate unique filename to prevent collisions
     * Format: {timestamp}-{random}-{original-name}
     * Example: 1708873200-a7f3k-health-program.jpg
     */
    private static function generateUniqueName(string $ext): string {
        $timestamp = time();
        $random = bin2hex(random_bytes(4)); // 8 random hex characters
        $filename = $timestamp . '-' . $random . '.' . $ext;
        return $filename;
    }

    /**
     * Delete a featured image
     * 
     * @param string $relativePath Path stored in database (e.g., 'featured-images/2024-02-25/1708873200-a7f3k.jpg')
     * @return array ['success' => bool, 'error' => string]
     */
    public static function delete(string $relativePath): array {
        if (empty($relativePath)) {
            return ['success' => false, 'error' => 'No image path provided'];
        }

        // Prevent directory traversal attacks
        if (strpos($relativePath, '..') !== false) {
            return ['success' => false, 'error' => 'Invalid path'];
        }

        $fullPath = __DIR__ . '/../assets/images/' . $relativePath;

        // Verify file exists and is in correct directory
        $realPath = realpath($fullPath);
        $baseRealPath = realpath(self::BASE_DIR);

        if (!$realPath || !$baseRealPath || strpos($realPath, $baseRealPath) !== 0) {
            return ['success' => false, 'error' => 'File not found or invalid path'];
        }

        // Delete file
        if (file_exists($realPath)) {
            if (!unlink($realPath)) {
                return ['success' => false, 'error' => 'Failed to delete file'];
            }

            // Try to clean up empty date folder
            $dateFolder = dirname($realPath);
            if (is_dir($dateFolder) && count(scandir($dateFolder)) == 2) { // . and ..
                @rmdir($dateFolder);
            }
        }

        return ['success' => true];
    }

    /**
     * Get image URL for frontend
     * 
     * @param string $relativePath Path stored in database
     * @return string Full URL to image
     */
    public static function getImageUrl(string $relativePath): string {
        if (empty($relativePath)) {
            return '';
        }
        return '/assets/images/' . $relativePath;
    }

    /**
     * Get organized stats about featured images
     */
    public static function getStats(): array {
        if (!is_dir(self::BASE_DIR)) {
            return ['total' => 0, 'folders' => [], 'totalSize' => 0];
        }

        $folders = scandir(self::BASE_DIR);
        $stats = [
            'total' => 0,
            'folders' => [],
            'totalSize' => 0,
            'oldestFolder' => null,
            'latestFolder' => null
        ];

        foreach ($folders as $folder) {
            if ($folder === '.' || $folder === '..') continue;

            $folderPath = self::BASE_DIR . '/' . $folder;
            if (!is_dir($folderPath)) continue;

            $files = array_diff(scandir($folderPath), ['.', '..']);
            $count = count($files);
            $size = 0;

            foreach ($files as $file) {
                $filePath = $folderPath . '/' . $file;
                if (is_file($filePath)) {
                    $size += filesize($filePath);
                }
            }

            $stats['total'] += $count;
            $stats['totalSize'] += $size;
            $stats['folders'][$folder] = [
                'count' => $count,
                'size' => $size,
                'sizeFormatted' => self::formatBytes($size)
            ];

            if (!$stats['oldestFolder'] || $folder < $stats['oldestFolder']) {
                $stats['oldestFolder'] = $folder;
            }
            if (!$stats['latestFolder'] || $folder > $stats['latestFolder']) {
                $stats['latestFolder'] = $folder;
            }
        }

        krsort($stats['folders']); // Sort by date descending

        return $stats;
    }

    /**
     * Format bytes to human-readable format
     */
    private static function formatBytes(int $bytes, int $precision = 2): string {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    /**
     * Clean up old images (older than specified days)
     * 
     * @param int $daysOld Delete images older than this many days
     * @return array ['success' => bool, 'deleted' => int, 'error' => string]
     */
    public static function cleanup(int $daysOld = 90): array {
        if ($daysOld < 1) {
            return ['success' => false, 'deleted' => 0, 'error' => 'Days must be at least 1'];
        }

        if (!is_dir(self::BASE_DIR)) {
            return ['success' => true, 'deleted' => 0];
        }

        $cutoffDate = date('Y-m-d', strtotime("-$daysOld days"));
        $deleted = 0;

        $folders = scandir(self::BASE_DIR);

        foreach ($folders as $folder) {
            if ($folder === '.' || $folder === '..') continue;

            // Check if folder name (YYYY-MM-DD) is older than cutoff
            if ($folder < $cutoffDate) {
                $folderPath = self::BASE_DIR . '/' . $folder;
                
                if (is_dir($folderPath)) {
                    $files = array_diff(scandir($folderPath), ['.', '..']);
                    
                    foreach ($files as $file) {
                        $filePath = $folderPath . '/' . $file;
                        if (is_file($filePath) && unlink($filePath)) {
                            $deleted++;
                        }
                    }
                    
                    @rmdir($folderPath);
                }
            }
        }

        return ['success' => true, 'deleted' => $deleted];
    }
}

/**
 * Convenience function for use in posts.php
 */
function uploadFeaturedImage(array $file): array {
    return FeaturedImageUploader::upload($file);
}

function deleteFeaturedImage(string $path): array {
    return FeaturedImageUploader::delete($path);
}

function getFeaturedImageUrl(string $path): string {
    return FeaturedImageUploader::getImageUrl($path);
}