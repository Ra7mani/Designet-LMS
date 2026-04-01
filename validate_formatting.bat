@echo off
REM Change to project directory
cd /d "c:\Users\vectus\Desktop\SoutPro\Designet-LMS"

REM Set up environment
setlocal enabledelayedexpansion

REM Run Pint validation on the 8 specific files
echo ========================================
echo FORMATTING VALIDATION - Laravel Pint
echo ========================================
echo.
echo Testing 8 files for compliance...
echo.

php vendor/bin/pint --test ^
  app/Livewire/Etudiant/QuizExamens.php ^
  app/Livewire/Formateur/MesEtudiants.php ^
  app/Livewire/Formateur/Quiz.php ^
  app/Models/Question.php ^
  app/Models/Quiz.php ^
  app/Models/QuizAttempt.php ^
  database/migrations/2026_03_31_231200_add_grading_columns_to_quiz_attempts.php ^
  database/migrations/2026_04_01_010000_add_quiz_exam_management_fields.php

set PINT_EXIT=%ERRORLEVEL%

echo.
echo ========================================
if %PINT_EXIT% equ 0 (
  echo RESULT: PASSED - All files are compliant
) else (
  echo RESULT: FAILED - Some files need formatting
)
echo ========================================

exit /b %PINT_EXIT%
