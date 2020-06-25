<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LecturerRequest extends FormRequest
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
        $rules = [
            'name' => ['required', 'string'],
        ];

        if (
            strtolower($this->getMethod()) === 'post' ||
            (
                strtolower($this->getMethod()) === 'patch' &&
                $this->route('lecturer')->name != $this->get('name')
            )
        ) {
            $rules['name'][] = 'unique:lecturers,name';
        }

        return $rules;
    }
}
