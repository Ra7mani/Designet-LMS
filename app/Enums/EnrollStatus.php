<?php

namespace App\Enums;

enum EnrollStatus: string
{
    case Active = 'active';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
}
