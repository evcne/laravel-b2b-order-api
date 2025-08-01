<?php

namespace App\Base;

use App\Helpers\Helper;

abstract class BaseService
{
    protected Helper $helper;
    protected ?string $refreshedToken = null;

    public function __construct(Helper $helper)
    {
        $this->helper = $helper;
    }

    /**
     * Başarılı response
     */
    protected function success($data = null, $message = 'Başarılı', $code = 200)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
            'token' => $this->refreshedToken
        ], $code);
    }

    /**
     * Hatalı response
     */
    protected function error($message = 'Bir hata oluştu', $code = 500, $errors = [])
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'errors' => $errors
        ], $code);
    }

}