<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttendanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'event_occurrence_id' => ['required', 'integer', 'exists:event_occurrences,id'],
            'service_date' => ['nullable', 'date'],
            'check_in_time' => ['nullable', 'date_format:H:i:s'],
            'check_out_time' => ['nullable', 'date_format:H:i:s', 'after:check_in_time'],
            'attendance_method' => ['nullable', 'string'],
            'biometric_data_id' => ['nullable', 'integer'],
            'recorded_by' => ['nullable', 'integer', 'exists:users,id'],
            'status' => ['required', 'string', 'in:present,absent,eventDone'],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }
}
