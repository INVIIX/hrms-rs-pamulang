<?php

namespace App\Enums;

enum Citizenship : string
{
    case WNI = 'WNI';
    case WNA = 'WNA';

    public function label(): string
    {
        return match($this) {
            self::WNI => 'Warga Negara Indonesia',
            self::WNA => 'Warga Negara Asing',
        };
    }
}
