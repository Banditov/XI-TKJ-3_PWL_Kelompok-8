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

        foreach ($allFiles as $file) {
            if ($file === '.' || $file === '..') continue;
            if (!in_array($file, $usedImages)) {
                $filePath = $uploadDir . $file;
                if (is_file($filePath) && unlink($filePath)) {
                    $deletedCount++;
                }
            }
        }

        $_SESSION['success'] = "Cleaned up {$deletedCount} unused image(s)";
        header("Location: /admin/cleanup");
        exit;
    }

    public function removeUnusedModels()
    {
        $this->requireAdmin();

        $postModel = new Post();
        $usedModels = $postModel->getAllUsedModels();
        $modelDir = __DIR__ . '/../../public/assets/models/';

        if (!is_dir($modelDir)) {
            $_SESSION['error'] = "Models directory not found";
            header("Location: /admin/cleanup");
            exit;
        }

        $allFiles = scandir($modelDir);
        $deletedCount = 0;

        foreach ($allFiles as $file) {
            if ($file === '.' || $file === '..') continue;
            if (!in_array($file, $usedModels)) {
                $filePath = $modelDir . $file;
                if (is_file($filePath) && unlink($filePath)) {
                    $deletedCount++;
                }
            }
        }

        $_SESSION['success'] = "Cleaned up {$deletedCount} unused 3D model(s)";
        header("Location: /admin/cleanup");
        exit;
    }

    public function showCleanupPage()
    {
        $this->requireAdmin();

        $postModel = new Post();

        $uploadDir = __DIR__ . '/../../public/assets/image/post/';
        $allImageFiles = is_dir($uploadDir) ? scandir($uploadDir) : [];
        $usedImages = $postModel->getAllUsedImages();

        $totalImages = 0;
        $unusedImages = [];

        foreach ($allImageFiles as $file) {
            if ($file === '.' || $file === '..') continue;
            $totalImages++;
            if (!in_array($file, $usedImages)) {
                $unusedImages[] = $file;
            }
        }

        $modelDir = __DIR__ . '/../../public/assets/models/';
        $allModelFiles = is_dir($modelDir) ? scandir($modelDir) : [];
        $usedModels = $postModel->getAllUsedModels();

        $totalModels = 0;
        $unusedModels = [];

        foreach ($allModelFiles as $file) {
            if ($file === '.' || $file === '..') continue;
            $totalModels++;
            if (!in_array($file, $usedModels)) {
                $unusedModels[] = $file;
            }
        }

        $this->view('admin.cleanup', [
            'totalImages' => $totalImages,
            'usedImages' => count($usedImages),
            'unusedImages' => $unusedImages,
            'unusedImageCount' => count($unusedImages),
            'totalModels' => $totalModels,
            'usedModels' => count($usedModels),
            'unusedModels' => $unusedModels,
            'unusedModelCount' => count($unusedModels)
        ]);
    }
}