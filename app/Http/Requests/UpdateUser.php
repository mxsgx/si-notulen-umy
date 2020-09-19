<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest
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
        $user = $this->route('user');
        $email = $this->get('email');
        $rules = [
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'role' => ['required', 'in:super-admin,admin,operator'],
            'study_id' => ['required_if:role,admin,operator', 'exists:studies,id'],
        ];

        if ($email != $user->email) {
            $rules['email'][] = 'unique:users,email';
        }

        if ($this->has('password') && !empty($this->get('password'))) {
            $rules['password'] = ['required', 'string', 'min:5'];
        }

        return $rules;
    }
}
