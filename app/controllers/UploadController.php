<?php
namespace App\Controllers;

use App\Core\Controller;

class UploadController extends Controller
{
    public function image()
    {
        header('Content-Type: application/json');

        if (!isset($_SESSION['account_id'])) {
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        if (empty($_FILES['image'])) {
            echo json_encode(['error' => 'No file received']);
            exit;
        }

        $file     = $_FILES['image'];
        $allowed  = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize  = 5 * 1024 * 1024; // 5MB

        if ($file['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['error' => 'Upload error: ' . $file['error']]);
            exit;
        }

        if (!in_array($file['type'], $allowed)) {
            echo json_encode(['error' => 'Invalid file type']);
            exit;
        }

        if ($file['size'] > $maxSize) {
            echo json_encode(['error' => 'File too large (max 5MB)']);
            exit;
        }

        $ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('post_', true) . '.' . $ext;
        $dest = __DIR__ . '/../../public/assets/image/post/' . $filename;

        if (!move_uploaded_file($file['tmp_name'], $dest)) {
            echo json_encode(['error' => 'Failed to save file']);
            exit;
        }

        echo json_encode(['filename' => $filename]);
        exit;
    }
}