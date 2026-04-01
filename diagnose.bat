@echo off
REM Quick diagnostic script for the 8 target files
echo ====================================================
echo DIAGNOSTIC REPORT FOR 8 TARGET FILES
echo ====================================================

cd /d "c:\Users\vectus\Desktop\SoutPro\Designet-LMS"

echo.
echo Checking if files exist:
if exist "app\Livewire\Etudiant\QuizExamens.php" echo [OK] QuizExamens.php
if exist "app\Livewire\Formateur\MesEtudiants.php" echo [OK] MesEtudiants.php
if exist "app\Livewire\Formateur\Quiz.php" echo [OK] Quiz.php
if exist "app\Models\Question.php" echo [OK] Question.php
if exist "app\Models\Quiz.php" echo [OK] Quiz.php
if exist "app\Models\QuizAttempt.php" echo [OK] QuizAttempt.php
if exist "database\migrations\2026_03_31_231200_add_grading_columns_to_quiz_attempts.php" echo [OK] Migration 1
if exist "database\migrations\2026_04_01_010000_add_quiz_exam_management_fields.php" echo [OK] Migration 2

echo.
echo Checking git status on target files:
git --no-pager status app\Livewire\Etudiant\QuizExamens.php app\Livewire\Formateur\MesEtudiants.php app\Livewire\Formateur\Quiz.php app\Models\Question.php app\Models\Quiz.php app\Models\QuizAttempt.php database\migrations\2026_03_31_231200_add_grading_columns_to_quiz_attempts.php database\migrations\2026_04_01_010000_add_quiz_exam_management_fields.php

echo.
echo PHP/Composer check:
php -v
echo.
echo Pint version:
php ./vendor/bin/pint --version
