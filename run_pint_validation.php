#!/usr/bin/env php
<?php
/**
 * Validate formatting of 8 specific PHP files using Laravel Pint
 */

$baseDir = 'c:\\Users\\vectus\\Desktop\\SoutPro\\Designet-LMS';
chdir($baseDir);

$files = [
    'app/Livewire/Etudiant/QuizExamens.php',
    'app/Livewire/Formateur/MesEtudiants.php',
    'app/Livewire/Formateur/Quiz.php',
    'app/Models/Question.php',
    'app/Models/Quiz.php',
    'app/Models/QuizAttempt.php',
    'database/migrations/2026_03_31_231200_add_grading_columns_to_quiz_attempts.php',
    'database/migrations/2026_04_01_010000_add_quiz_exam_management_fields.php',
];

echo "Running Laravel Pint validation on 8 files...\n";
echo "============================================\n\n";

// Run pint --test on these specific files
$cmd = 'vendor\\bin\\pint --test ' . implode(' ', array_map('escapeshellarg', $files));

// Capture output
$output = [];
$exitCode = 0;
exec($cmd . ' 2>&1', $output, $exitCode);

// Display output
echo implode("\n", $output) . "\n";

// Show result
echo "\n============================================\n";
if ($exitCode === 0) {
    echo "✓ VALIDATION PASSED - All files are compliant\n";
} else {
    echo "✗ VALIDATION FAILED - See details above\n";
}

exit($exitCode);
?>
