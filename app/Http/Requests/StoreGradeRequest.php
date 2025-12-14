<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGradeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && (auth()->user()->isTeacher() || auth()->user()->isAdmin());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'student_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'grade' => 'required|numeric|min:1|max:6',
            'weight' => 'required|integer|min:1|max:10',
            'type' => 'required|in:sprawdzian,kartkówka,odpowiedź,zadanie',
            'description' => 'nullable|string|max:500',
            'class_id' => 'required|exists:school_classes,id',
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
            'student_id.required' => 'Pole uczeń jest wymagane.',
            'student_id.exists' => 'Wybrany uczeń nie istnieje.',
            'subject_id.required' => 'Pole przedmiot jest wymagane.',
            'subject_id.exists' => 'Wybrany przedmiot nie istnieje.',
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
            'class_id.required' => 'Pole klasa jest wymagane.',
            'class_id.exists' => 'Wybrana klasa nie istnieje.',
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
            'student_id' => 'uczeń',
            'subject_id' => 'przedmiot',
            'grade' => 'ocena',
            'weight' => 'waga',
            'type' => 'typ oceny',
            'description' => 'opis',
            'class_id' => 'klasa',
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

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // Sprawdź czy nauczyciel może wystawiać oceny z tego przedmiotu dla tego ucznia
            if (!$validator->errors()->has('student_id') &&
                !$validator->errors()->has('subject_id') &&
                !$validator->errors()->has('class_id')) {

                $student = \App\Models\User::find($this->student_id);
                $subject = \App\Models\Subject::find($this->subject_id);
                $teacher = auth()->user();

                if ($student && $subject && $teacher->isTeacher()) {
                    if (!$subject->isTaughtByTeacherInClass($teacher->id, $student->class_id)) {
                        $validator->errors()->add('subject_id', 'Nie masz uprawnień do wystawiania ocen z tego przedmiotu dla tego ucznia.');
                    }
                }

                // Sprawdź czy uczeń należy do wybranej klasy
                if ($student && $student->class_id != $this->class_id) {
                    $validator->errors()->add('student_id', 'Uczeń nie należy do wybranej klasy.');
                }
            }
        });
    }
}