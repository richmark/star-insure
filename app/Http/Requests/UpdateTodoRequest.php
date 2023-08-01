<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateTodoRequest
 * @package App\Http\Requests
 * @author Richmark <richmark.jinn.ravina@gmail.com>
 * @date 08/01/2023 5:54 PM
 */
class UpdateTodoRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'ids'  => ['required']
        ];
    }
}
