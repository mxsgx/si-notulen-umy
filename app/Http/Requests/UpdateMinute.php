<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMinute extends FormRequest
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
            'study_id' => ['required', 'exists:studies,id'],
            'agenda' => ['required', 'string'],
            'lecturer_id' => ['required', 'exists:lecturers,id'],
            'notulis_id' => ['required', 'exists:lecturers,id'],
            'presents.*' => ['required', 'exists:lecturers,id'],
            'meeting_id' => ['required', 'exists:meetings,id'],
            'room_id' => ['required', 'exists:rooms,id'],
            'meeting_date' => ['required', 'date', 'date_format:Y-m-d'],
            'start_at' => ['required', 'date_format:H:i'],
            'end_at' => ['required', 'date_format:H:i'],
            'note' => ['nullable', 'string'],
            'attachments.*' => ['nullable', 'file', 'mimes:docx,pdf,jpeg,png'],
            'delete_attachments.*' => ['nullable', 'exists:documents,id'],
            'signature_minute' => ['nullable', 'file', 'mimes:docx,pdf,jpeg,png'],
        ];
    }
}
