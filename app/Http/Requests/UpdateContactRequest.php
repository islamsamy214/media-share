<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactRequest extends FormRequest
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
        return [
            'email' => ['required', 'string', 'email', 'max:255'],
            'facebook_id' => ['nullable', 'string'],
            'linkedin_id' => ['nullable', 'string'],
            'twitter_id' => ['nullable', 'string'],
            'youtube_id' => ['nullable', 'string'],
            'instagram_id' => ['nullable', 'string'],
        ];
    }
}
