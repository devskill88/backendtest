<?php

namespace App\Traits;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

trait ApiResponse
{

    protected $pagination;

    public static function successResponse($data = [], string $message = '')
    {
        return response()->json([
            'success' => true,
            'requester' => new UserResource(auth()->user()),
            'message' => $message,
            'data' => $data,
            'pagination' => static::pagination($data)
        ]);
    }

    protected static function pagination($data)
    {
        if (!($data instanceof ResourceCollection)){
            return [];
        }
        return [
            'total' => $data->total(),
            'per_page' => $data->perPage(),
            'current_page' => $data->currentPage(),
            'last_page' => $data->lastPage(),
            'from' => $data->firstItem(),
            'to' => $data->lastItem(),
        ];
    }

    public static function unsuccessResponse(string|array $message, $code = 500) :JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $code);
    }
}