<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessageRequest extends FormRequest
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
            'sender_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'string', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string']
        ];
    }
}
