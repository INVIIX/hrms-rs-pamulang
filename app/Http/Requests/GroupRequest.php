<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'string|max:255',
            '_lft' => 'integer',
            '_rgt' => 'integer',
            'parent_id' => 'integer',
        ];
    }
}
