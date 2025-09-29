<?php

namespace App\Enums;

enum LoanStatus : string
{
    case Aktif = 'Aktif';
    case Pending = 'Pending';
    case Selesai = 'Selesai';
}
