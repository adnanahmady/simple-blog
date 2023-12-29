<?php

namespace App\Http\Requests\Web\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public const EMAIL = 'email';
    public const PASSWORD = 'password';

    /** Determine if the user is authorized to make this request. */
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
            self::EMAIL => ['required', 'email'],
            self::PASSWORD => ['required', 'min:6'],
        ];
    }

    public function email(): string
    {
        return $this->{self::EMAIL};
    }

    public function password(): string
    {
        return $this->{self::PASSWORD};
    }
}
