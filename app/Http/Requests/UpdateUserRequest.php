<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user')->id;

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $userId,
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'class_id' => 'nullable|exists:school_classes,id',
            'pesel' => ['required', 'regex:/^[0-9]{11}$/', 'unique:users,pesel,' . $userId],
            'phone' => ['nullable', 'regex:/^[0-9]{9}$/'],
            'address' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Pole imię i nazwisko jest wymagane.',
            'name.max' => 'Imię i nazwisko nie może być dłuższe niż 255 znaków.',
            'email.required' => 'Pole email jest wymagane.',
            'email.email' => 'Podaj prawidłowy adres email.',
            'email.unique' => 'Ten adres email jest już zajęty.',
            'password.min' => 'Hasło musi mieć co najmniej 8 znaków.',
            'password.confirmed' => 'Potwierdzenie hasła nie pasuje.',
            'role_id.required' => 'Pole rola jest wymagane.',
            'role_id.exists' => 'Wybrana rola nie istnieje.',
            'class_id.exists' => 'Wybrana klasa nie istnieje.',
            'pesel.required' => 'Pole PESEL jest wymagane.',
            'pesel.regex' => 'PESEL musi składać się z 11 cyfr.',
            'pesel.unique' => 'Ten PESEL jest już zarejestrowany w systemie.',
            'phone.regex' => 'Numer telefonu musi składać się z 9 cyfr.',
            'address.max' => 'Adres nie może być dłuższy niż 500 znaków.',
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'imię i nazwisko',
            'email' => 'email',
            'password' => 'hasło',
            'role_id' => 'rola',
            'class_id' => 'klasa',
            'pesel' => 'PESEL',
            'phone' => 'telefon',
            'address' => 'adres',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // Sprawdź czy nie próbujemy edytować własnego konta
            if ($this->route('user')->id === auth()->id()) {
                // Nie pozwalaj na zmianę własnej roli
                if ($this->role_id != auth()->user()->role_id) {
                    $validator->errors()->add('role_id', 'Nie możesz zmienić swojej własnej roli.');
                }
            }

            // Sprawdź czy klasa jest wymagana dla uczniów
            if (!$validator->errors()->has('role_id') && !$validator->errors()->has('class_id')) {
                $role = \App\Models\Role::find($this->role_id);

                if ($role && $role->name === 'student' && !$this->class_id) {
                    $validator->errors()->add('class_id', 'Klasa jest wymagana dla uczniów.');
                }

                // Nauczyciele i administratorzy nie powinni mieć przypisanej klasy
                if ($role && in_array($role->name, ['teacher', 'admin']) && $this->class_id) {
                    $validator->errors()->add('class_id', 'Nauczyciele i administratorzy nie powinni mieć przypisanej klasy.');
                }
            }

            // Walidacja PESEL (podstawowa)
            if (!$validator->errors()->has('pesel') && $this->pesel) {
                if (!$this->validatePesel($this->pesel)) {
                    $validator->errors()->add('pesel', 'Podany PESEL jest nieprawidłowy.');
                }
            }
        });
    }

    /**
     * Podstawowa walidacja numeru PESEL.
     *
     * @param string $pesel
     * @return bool
     */
    private function validatePesel(string $pesel): bool
    {
        if (strlen($pesel) !== 11 || !ctype_digit($pesel)) {
            return false;
        }

        $weights = [1, 3, 7, 9, 1, 3, 7, 9, 1, 3];
        $sum = 0;

        for ($i = 0; $i < 10; $i++) {
            $sum += $pesel[$i] * $weights[$i];
        }

        $checksum = (10 - ($sum % 10)) % 10;

        return $checksum == $pesel[10];
    }
}