<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class DeleteTodoRequest
 * @package App\Http\Requests
 * @author Richmark <richmark.jinn.ravina@gmail.com>
 * @date 08/02/2023 10:36 AM
 */
class DeleteTodoRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'id'  => ['required','exists:todos,id']
        ];
    }

    /**
     * Merge the todo_id as id to be validated on rules function
     */
    public function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('todo_id')
        ]);
    }
}
