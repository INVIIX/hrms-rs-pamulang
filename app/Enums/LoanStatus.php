<?php

namespace App\Enums;

enum LoanStatus : string
{
    case AKTIF = 'Aktif';
    case PENDING = 'Pending';
    case SELESAI = 'Selesai';
}
