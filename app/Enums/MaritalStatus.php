<?php

namespace App\Enums;

enum MaritalStatus : string
{
    case BK     = 'Belum Kawin';
    case KBT    = 'Kawin Belum Tercatat';
    case KT     = 'Kawin Tercatat';
    case CH     = 'Cerai Hidup';
    case CM     = 'Cerai Mati';
}
