<?php
/**
 * AJAX Upload Handler for Post Images
 * 
 * Endpoint: /admin/upload-post-images.php
 * Method: POST
 * Expects: $_FILES['image']
 * Returns: JSON
 */

header('Content-Type: application/json; charset=utf-8');
session_start();

// Require error reporting
error_reporting(E_ALL);
ini_set('display_errors', '0'); // Don't display errors, only JSON

// Check authentication
if (!isset($_SESSION['admin_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/post-image-uploader.php';

try {
    // Validate request
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['success' => false, 'error' => 'Method not allowed']);
        exit;
    }

    if (!isset($_FILES['image'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'No image file provided']);
        exit;
    }

    // Handle upload
    $result = PostImageUploader::upload($_FILES['image']);

    if ($result['success']) {
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'path' => $result['path'],
            'url' => $result['url'],
            'filename' => $result['filename']
        ]);
    } else {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => $result['error']
        ]);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Server error: ' . $e->getMessage()
    ]);
}

exit;