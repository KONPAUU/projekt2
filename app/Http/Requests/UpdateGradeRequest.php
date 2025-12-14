<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGradeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $grade = $this->route('grade');
        $user = auth()->user();

        // Sprawdź czy użytkownik może edytować tę ocenę
        return $user && (
            $user->isAdmin() ||
            ($user->isTeacher() && $grade && $grade->teacher_id === $user->id)
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'grade' => 'required|numeric|min:1|max:6',
            'weight' => 'required|integer|min:1|max:10',
            'type' => 'required|in:sprawdzian,kartkówka,odpowiedź,projekt,praca_domowa,aktywność',
            'description' => 'nullable|string|max:500',
            'reason' => 'nullable|string|max:500', // Powód zmiany oceny
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
            'grade.required' => 'Pole ocena jest wymagane.',
            'grade.numeric' => 'Ocena musi być liczbą.',
            'grade.min' => 'Ocena musi być co najmniej 1.',
            'grade.max' => 'Ocena nie może być większa niż 6.',
            'weight.required' => 'Pole waga jest wymagane.',
            'weight.integer' => 'Waga musi być liczbą całkowitą.',
            'weight.min' => 'Waga musi być co najmniej 1.',
            'weight.max' => 'Waga nie może być większa niż 10.',
            'type.required' => 'Pole typ oceny jest wymagane.',
            'type.in' => 'Nieprawidłowy typ oceny.',
            'description.max' => 'Opis nie może być dłuższy niż 500 znaków.',
            'reason.max' => 'Powód zmiany nie może być dłuższy niż 500 znaków.',
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
            'grade' => 'ocena',
            'weight' => 'waga',
            'type' => 'typ oceny',
            'description' => 'opis',
            'reason' => 'powód zmiany',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        // Konwersja przecinka na kropkę w ocenie
        if ($this->has('grade')) {
            $this->merge([
                'grade' => str_replace(',', '.', $this->grade)
            ]);
        }
    }
}