<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MeetingRequest extends FormRequest
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
                $this->route('meeting')->name != $this->get('name')
            )
        ) {
            $rules['name'][] = 'unique:meetings,name';
        }

        return $rules;
    }
}
