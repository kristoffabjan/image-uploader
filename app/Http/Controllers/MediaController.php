<?php

namespace App\Http\Controllers;

use App\Http\Requests\MediaUploadRequest;
use App\Models\Media;
use Illuminate\Http\JsonResponse;

class MediaController extends Controller
{
    public function store(MediaUploadRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        // Store the file
        $file = $request->file('media');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('media', $filename);

        // Save the media record
        $media = Media::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'filename' => $filename,
            'file_type' => $file->getClientMimeType(),
            'size' => Media::formatBytes($file->getSize(), 2),
            'path' => 'media/' . $filename
        ]);

        return response()->json([
            'message' => 'Media uploaded successfully.',
            'data' => [
                'file_type' => $file->getClientMimeType(),
                'size' => Media::formatBytes($file->getSize(), 2),
                'path' => 'media/' . $filename
            ]
        ], 201);
    }
}
