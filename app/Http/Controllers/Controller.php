<?php

namespace App\Http\Controllers;

use App\Utils\ResponseUtil;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param $result
     * @param $message
     * @param int $status
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponse($result, $message, $status = 200)
    {
        if ($result instanceof Model) {
            $result = $result->toArray();
        }

        return Response::json(ResponseUtil::makeResponse($message, $result), $status);
    }

    /**
     * @param $error
     * @param int $status
     * @param array $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendError($error, $status = 400, $data = [])
    {
        return Response::json(ResponseUtil::makeError($error, $data), $status);
    }
}
