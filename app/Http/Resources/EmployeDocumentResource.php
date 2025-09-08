<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeDocumentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "tax" => new DocumentResource($this->tax),
            "kontrak" => new DocumentResource($this->kontrak),
            "asuransi" => new DocumentResource($this->asuransi),
            "str_letter" => new DocumentResource($this->str_letter),
            "sp_letter" => new DocumentResource($this->sp_letter),
            "certificates" => DocumentResource::collection($this->certificates),
            "other_document" => new DocumentResource($this->other_document),
            "surat_perjanjian_lainnya" => new DocumentResource($this->surat_perjanjian_lainnya),
            "ktp" => new DocumentResource($this->ktp),
            "kartu_keluarga" => new DocumentResource($this->kartu_keluarga),
            "akta_kelahiran" => new DocumentResource($this->akta_kelahiran),
            "npwp" => new DocumentResource($this->npwp),
            "ijazah" => new DocumentResource($this->ijazah)
        ];
    }
}
