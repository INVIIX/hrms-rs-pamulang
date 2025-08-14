<?php

namespace App\Enums;

enum Relationship: string
{
    // Keluarga inti
    case SPOUSE = 'spouse';
    case CHILD = 'child';
    case PARENT = 'parent';
    case SIBLING = 'sibling';
        // Kerabat dekat
    case COUSIN = 'cousin';
    case UNCLE = 'uncle';
    case AUNT = 'aunt';
    case GUARDIAN = 'guardian';
        // Teman dan kontak lain
    case FRIEND = 'friend';
    case EMERGENCY_CONTACT = 'emergency_contact';
    case NEIGHBOR = 'neighbor';
    case OTHER = 'other';
}
