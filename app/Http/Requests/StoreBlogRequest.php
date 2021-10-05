<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $regex = '/^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/';

        return [
            'title' => ['required', 'max:280', 'string'],
            'image' => ['nullable', 'image', 'max:2000'],
            'content' => ['required'],
            'youtube_link' => ['nullable', 'regex:' . $regex],
            'categories' => ['required'],
            'user_id' => ['required', 'integer']
        ];
    }
}
