@echo off
cd /d c:\Users\vectus\Desktop\SoutPro\Designet-LMS
echo Running Laravel Pint validation on 8 files...
echo.
vendor\bin\pint --test ^
  app/Livewire/Etudiant/QuizExamens.php ^
  app/Livewire/Formateur/MesEtudiants.php ^
  app/Livewire/Formateur/Quiz.php ^
  app/Models/Question.php ^
  app/Models/Quiz.php ^
  app/Models/QuizAttempt.php ^
  database/migrations/2026_03_31_231200_add_grading_columns_to_quiz_attempts.php ^
  database/migrations/2026_04_01_010000_add_quiz_exam_management_fields.php
echo.
echo.
if %ERRORLEVEL% EQU 0 (
  echo VALIDATION PASSED: All 8 files are formatting compliant!
) else (
  echo VALIDATION FAILED: See details above
)
pause
