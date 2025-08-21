<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property \Illuminate\Http\UploadedFile|\Illuminate\Http\UploadedFile[] $file
 * @method \Illuminate\Routing\Route route(string $param = null)
 * @method bool hasFile(string $key)
 * @method mixed file(string $key)
 */
class EmployeeDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'collection' => 'required|string|in:tax,kontrak,asuransi,str_letter,certificates,other_document,surat_perjanjian_lainnya,ktp,kartu_keluarga,akta_kelahiran,npwp,ijazah',
            'file' => 'required|file'
        ];
    }
}
