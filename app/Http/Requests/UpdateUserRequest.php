<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->user)],
            'title' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2000'],
            'cv' => ['nullable', 'mimes:pdf,docx,doc', 'max:2500'],
            'about' => ['nullable', 'string'],
            'education' => ['nullable', 'string'],
            'country' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'facebook_id' => ['nullable', 'string'],
            'linkedin_id' => ['nullable', 'string'],
            'twitter_id' => ['nullable', 'string'],
            'github_id' => ['nullable', 'string'],
            'behance_id' => ['nullable', 'string'],
            'youtube_id' => ['nullable', 'string'],
            'instagram_id' => ['nullable', 'string'],
            'skills' => ['required'],
            'languages' => ['required'],
            'permissions' => ['required'],
        ];
    }
}
