<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkRequest extends FormRequest
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
        $regex = "#[-a-zA-Z0-9@:%_\+.~\#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~\#?&//=]*)?#si";

        return [
            'title' => ['required', 'max:280', 'string'],
            'image' => ['nullable', 'image', 'max:2000'],
            'description' => ['required'],
            'link' => ['nullable', 'regex:' . $regex],
            'work_date' => ['required', 'date'],
            'categories' => ['required'],
            'user_id' => ['required', 'integer'],
        ];
    }
}
