<?php

namespace App\Http\Requests\Web\Articles;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public const CONTENT = 'content';
    public const TITLE = 'title';

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
            self::TITLE => ['required', 'min:5'],
            self::CONTENT => ['required', 'min:10'],
        ];
    }

    public function title(): string
    {
        return $this->{self::TITLE};
    }

    public function content(): string
    {
        return $this->get(self::CONTENT);
    }
}
