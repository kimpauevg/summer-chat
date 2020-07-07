<?php

namespace App\Models\Utils;
class Response
{
    public static function ok($data = null)
    {
        return [
            'message' => 'success',
            'data' => $data
        ];
    }
    public static function error($data = null)
    {
        return [
            'message' => 'error',
            'data' => $data
        ];
    }

}