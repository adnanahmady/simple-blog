<?php

namespace App\Http\Requests\Web\Articles;

use Illuminate\Foundation\Http\FormRequest;

class ApproveRequest extends FormRequest
{
    public const APPROVED = 'approved';

    /** Determine if the user is authorized to make this request. */
    public function authorize(): bool
    {
        return (bool) $this->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            self::APPROVED => ['required', 'boolean'],
        ];
    }

    public function isApproved(): bool
    {
        return $this->{self::APPROVED};
    }
}
