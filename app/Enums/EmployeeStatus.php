<?php

namespace App\Enums;

enum EmployeeStatus : string
{
    case ACTIVE     = 'Active';
    case PROBATION  = 'Probation';
    case RESIGNED   = 'Resigned';
    case TERMINATED = 'Terminated';
    case RETIRED    = 'Retired';
}
