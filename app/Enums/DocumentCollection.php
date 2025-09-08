<?php

namespace App\Enums;

enum DocumentCollection: string
{
    case TAX = "tax";
    case KONTRAK = "kontrak";
    case ASURANSI = "asuransi";
    case STR_LETTER = "str_letter";
    case SP_LETTER = "sp_letter";
    case CERTIFICATES = "certificates";
    case OTHER_DOCUMENT = "other_document";
    case SURAT_PERJANJIAN_LAINNYA = "surat_perjanjian_lainnya";
    case KTP = "ktp";
    case KARTU_KELUARGA = "kartu_keluarga";
    case AKTA_KELAHIRAN = "akta_kelahiran";
    case NPWP = "npwp";
    case IJAZAH = "ijazah";
}
