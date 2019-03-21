<?php

namespace App\Utils;

class ResponseUtil
{
    /**
     * @param string $message
     * @param mixed  $data
     *
     * @return array
     */
    public static function makeResponse($message, $data)
    {
        return self::response(true, $message, $data);
    }

    /**
     * @param string $message
     * @param array  $data
     *
     * @return array
     */
    public static function makeError($message, array $data = [])
    {
        return self::response(false, $message, $data);
    }

    /**
     * @param bool   $success
     * @param string $message
     * @param array  $data
     *
     * @return array
     */
    public static function response($success, $message, $data = [])
    {
        $res = [
            'success' => $success,
            'message' => $message,
        ];

        if (!empty($data)) {
            $res['data'] = $data;
        } else {
            $res['data'] = [];
        }

        return $res;
    }
}
