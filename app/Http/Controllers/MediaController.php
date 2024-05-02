<?php

namespace App\Http\Controllers;

use App\Http\Requests\MediaUploadRequest;
use Illuminate\Http\JsonResponse;

class MediaController extends Controller
{
    public function store(MediaUploadRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        
        $file = $request->file('media');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('media', $filename);

        return response()->json([
            'test' => "test"
        ]);
    }
}
