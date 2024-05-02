<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class MediaUploadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:50',
            'description' => 'required|string|max:200',
            'media' => [
                'required',
                'file',
                File::types(['image/jpeg', 'image/png', 'video/mp4'])
                    ->max(8 * 1024),
            ],
        ];
    }
}
