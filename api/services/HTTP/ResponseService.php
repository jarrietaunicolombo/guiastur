<?php

namespace Api\Services;

class ResponseService
{
    public function sendSuccessResponse($data)
    {
        http_response_code(200);
        echo json_encode($data);
        exit();
    }

    public function sendErrorResponse($message, $code = 400)
    {
        http_response_code($code);
        echo json_encode(["error" => $message]);
        exit();
    }
}
