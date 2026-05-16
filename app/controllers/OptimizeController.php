<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Post;

class OptimizeController extends Controller
{
    public function optimizeExisting()
    {
        $this->requireAdmin();

        $uploadDir = __DIR__ . '/../../public/assets/image/post/';
        $files = scandir($uploadDir);
        $optimized = 0;
        $failed = 0;

        foreach ($files as $file) {
            if ($file === '.' || $file === '..') continue;

            $filePath = $uploadDir . $file;
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

            if ($ext === 'webp') continue;

            $imageInfo = getimagesize($filePath);
            if (!$imageInfo) continue;

            $sourceImage = null;
            switch ($imageInfo['mime']) {
                case 'image/jpeg':
                    $sourceImage = imagecreatefromjpeg($filePath);
                    break;
                case 'image/png':
                    $sourceImage = imagecreatefrompng($filePath);
                    break;
                case 'image/gif':
                    $sourceImage = imagecreatefromgif($filePath);
                    break;
                default:
                    continue;
            }

            if (!$sourceImage) continue;

            $newFilename = pathinfo($file, PATHINFO_FILENAME) . '.webp';
            $newPath = $uploadDir . $newFilename;

            imagewebp($sourceImage, $newPath, 85);
            unset($sourceImage);

            if (file_exists($newPath)) {
                unlink($filePath);
                $optimized++;
            } else {
                $failed++;
            }
        }

        echo json_encode([
            'success' => true,
            'optimized' => $optimized,
            'failed' => $failed
        ]);
    }
}