<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Post;

class CleanupController extends Controller
{
    public function removeUnusedImages()
    {
        $this->requireAdmin();

        $postModel = new Post();

        $usedImages = $postModel->getAllUsedImages();

        $uploadDir = __DIR__ . '/../../public/assets/image/post/';
        $allFiles = scandir($uploadDir);

        $deletedCount = 0;
        $deletedFiles = [];

        foreach ($allFiles as $file) {
            if ($file === '.' || $file === '..') continue;

            if (!in_array($file, $usedImages)) {
                $filePath = $uploadDir . $file;
                if (is_file($filePath) && unlink($filePath)) {
                    $deletedCount++;
                    $deletedFiles[] = $file;
                }
            }
        }

        $_SESSION['success'] = "Cleaned up {$deletedCount} unused image(s)";
        header("Location: /admin/cleanup");
        exit;
    }
    
    public function showCleanupPage()
    {
        $this->requireAdmin();

        $postModel = new Post();

        $uploadDir = __DIR__ . '/../../public/assets/image/post/';
        $allFiles = scandir($uploadDir);
        $usedImages = $postModel->getAllUsedImages();

        $totalImages = 0;
        $unusedImages = [];

        foreach ($allFiles as $file) {
            if ($file === '.' || $file === '..') continue;
            $totalImages++;
            if (!in_array($file, $usedImages)) {
                $unusedImages[] = $file;
            }
        }

        $this->view('admin.cleanup', [
            'totalImages' => $totalImages,
            'usedImages' => count($usedImages),
            'unusedImages' => $unusedImages,
            'unusedCount' => count($unusedImages)
        ]);
    }
}