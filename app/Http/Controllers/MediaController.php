<?php

namespace App\Http\Controllers;

use App\Http\Requests\MediaUploadRequest;
use Illuminate\Http\JsonResponse;

class MediaController extends Controller
{
    public function store(MediaUploadRequest $request) : JsonResponse {

        return response()->json([
            'test' => "test"
        ]);
    }
}
