<?php
namespace app\controllers;

use app\core\controller;

// 2 KODE HOSTING
class uploadcontroller extends controller
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

        $file = $_FILES['image'];
        $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 10 * 1024 * 1024;

        if ($file['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['error' => 'Upload error: ' . $file['error']]);
            exit;
        }

        if (!in_array($file['type'], $allowed)) {
            echo json_encode(['error' => 'Invalid file type']);
            exit;
        }

        if ($file['size'] > $maxSize) {
            echo json_encode(['error' => 'File too large (max 10MB)']);
            exit;
        }

        $config = [
            'max_width' => 1920,
            'max_height' => 1920,
            'quality' => 80,
            'original_size' => $file['size']
        ];

        $imageInfo = getimagesize($file['tmp_name']);
        if (!$imageInfo) {
            echo json_encode(['error' => 'Invalid image file']);
            exit;
        }

        $origWidth = $imageInfo[0];
        $origHeight = $imageInfo[1];
        $mimeType = $file['type'];

        if ($origWidth <= $config['max_width'] && $origHeight <= $config['max_height']) {
            $newWidth = $origWidth;
            $newHeight = $origHeight;
        } else {
            list($newWidth, $newHeight) = $this->calculateDimensions($origWidth, $origHeight, $config);
        }

        $sourceImage = $this->createImageFromFile($file['tmp_name'], $mimeType);
        if (!$sourceImage) {
            echo json_encode(['error' => 'Failed to process image']);
            exit;
        }

        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

        $this->preserveTransparency($resizedImage, $sourceImage, $mimeType, $newWidth, $newHeight);

        imagecopyresampled($resizedImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

        $filename = 'post_' . uniqid() . '.webp';
        $dest = __DIR__ . '/../../public/assets/image/post/' . $filename;
        // HOSTING
        // $dest = __DIR__ . '/../../assets/image/post/' . $filename;

        $dir = dirname($dest);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        imagewebp($resizedImage, $dest, $config['quality']);

        unset($sourceImage);
        unset($resizedImage);

        if (!file_exists($dest)) {
            echo json_encode(['error' => 'Failed to save optimized image']);
            exit;
        }

        $newSize = filesize($dest);
        $savedPercentage = round((1 - $newSize / $file['size']) * 100, 2);

        echo json_encode([
            'success' => true,
            'filename' => $filename,
            'original_size' => $file['size'],
            'new_size' => $newSize,
            'saved_percentage' => $savedPercentage,
            'width' => $newWidth,
            'height' => $newHeight,
            'quality' => $config['quality']
        ]);
        exit;
    }

    private function createImageFromFile($path, $mimeType)
    {
        switch ($mimeType) {
            case 'image/jpeg':
                return imagecreatefromjpeg($path);
            case 'image/png':
                return imagecreatefrompng($path);
            case 'image/gif':
                return imagecreatefromgif($path);
            case 'image/webp':
                return imagecreatefromwebp($path);
            default:
                return null;
        }
    }

    private function calculateDimensions($width, $height, $config)
    {
        $newWidth = $width;
        $newHeight = $height;

        if ($width > $config['max_width']) {
            $newWidth = $config['max_width'];
            $newHeight = intval($height * ($config['max_width'] / $width));
        }

        if ($newHeight > $config['max_height']) {
            $newHeight = $config['max_height'];
            $newWidth = intval($newWidth * ($config['max_height'] / $newHeight));
        }

        return [$newWidth, $newHeight];
    }

    private function preserveTransparency($resizedImage, $sourceImage, $mimeType, $width, $height)
    {
        if ($mimeType === 'image/png') {
            imagealphablending($resizedImage, false);
            imagesavealpha($resizedImage, true);
            $transparent = imagecolorallocatealpha($resizedImage, 255, 255, 255, 127);
            imagefilledrectangle($resizedImage, 0, 0, $width, $height, $transparent);
        } elseif ($mimeType === 'image/gif') {
            imagealphablending($resizedImage, false);
            imagesavealpha($resizedImage, true);
            $transparent = imagecolorallocatealpha($resizedImage, 0, 0, 0, 127);
            imagefilledrectangle($resizedImage, 0, 0, $width, $height, $transparent);
        }
    }

    public function model3d()
    {
        header('Content-Type: application/json');

        if (!isset($_SESSION['account_id'])) {
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        if (empty($_FILES['model_3d'])) {
            echo json_encode(['error' => 'No file received']);
            exit;
        }

        $file = $_FILES['model_3d'];
        $allowed = ['glb', 'gltf', 'obj'];
        $maxSize = 10 * 1024 * 1024; // 10MB

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if ($file['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['error' => 'Upload error: ' . $file['error']]);
            exit;
        }

        if (!in_array($ext, $allowed)) {
            echo json_encode(['error' => 'Invalid file type. Use .glb, .gltf, or .obj']);
            exit;
        }

        if ($file['size'] > $maxSize) {
            echo json_encode(['error' => 'File too large (max 10MB)']);
            exit;
        }

        $filename = 'model_' . uniqid() . '.' . $ext;
        $uploadDir = __DIR__ . '/../../public/assets/models/';
        // HOSTING
        // $uploadDir = __DIR__ . '/../../assets/models/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $destination = $uploadDir . $filename;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            echo json_encode(['error' => 'Failed to save file']);
            exit;
        }

        echo json_encode([
            'success' => true,
            'filename' => $filename,
            'size' => $file['size']
        ]);
        exit;
    }
}