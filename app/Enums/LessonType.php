<?php

namespace App\Enums;

enum LessonType: string
{
    case Video = 'video';
    case Document = 'document';
    case Text = 'text';
    case Live = 'live';
}
