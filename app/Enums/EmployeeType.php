<?php

namespace App\Enums;

enum EmployeeType : string
{
    case PERMANENT  = 'Permanent';
    case CONTRACT   = 'Contract';
    case INTERNSHIP = 'Internship';
    case FREELANCE  = 'Freelance';
    case TEMPORARY  = 'Temporary';
}
