<?php

namespace App\Enums;

enum LeaveUnitType: string
{
    case CALENDAR = 'K';
    case ACTUAL = 'A';

    public function label(): string
    {
        return match ($this) {
            self::CALENDAR  => 'Kalender',
            self::ACTUAL    => 'Aktual',
        };
    }
}
