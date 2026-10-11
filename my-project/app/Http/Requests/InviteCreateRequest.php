<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InviteCreateRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255'],
            'company_name' => ['sometimes','required','string','max:255'],
            'role_id' => ['sometimes','required','integer'],
        ];
    }
}
