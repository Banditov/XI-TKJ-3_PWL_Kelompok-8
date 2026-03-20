<?php
namespace App\Controllers;

class ErrorController extends BaseController
{
    public function error404()
    {
        http_response_code(404);

        $data = [
            'error_code' => 404,
            'error_message' => 'Page Not Found',
            'error_description' => 'The page you are looking for does not exist or has been moved.'
        ];

        $this->render('component/error/404', $data);
    }
}