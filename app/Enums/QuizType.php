<?php

namespace App\Enums;

enum QuizType : string
{
    case Exam = 'exam';
    case Quiz = 'quiz';
    case Devoir = 'devoir';
}
