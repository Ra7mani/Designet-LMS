#!/usr/bin/env php
<?php

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

echo "=== Step 1: Converting all files to LF line endings ===\n";
foreach ($files as $file) {
    $fullPath = $baseDir . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $file);
    if (!file_exists($fullPath)) {
        echo "✗ File not found: $file\n";
        continue;
    }
    
    $content = file_get_contents($fullPath);
    // Convert CRLF to LF
    $content = str_replace("\r\n", "\n", $content);
    // Remove any remaining CR
    $content = str_replace("\r", "\n", $content);
    
    file_put_contents($fullPath, $content);
    echo "✓ Converted " . basename($file) . " to LF\n";
}

echo "\n=== Step 2: Verifying unary operator spacing ===\n";
$hasIssues = false;
foreach ($files as $file) {
    $fullPath = $baseDir . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $file);
    $content = file_get_contents($fullPath);
    
    // Check for !$ or !S where S is not a space or whitespace
    if (preg_match('/!\S(?![=!<>])/', $content, $matches)) {
        echo "⚠ Potential spacing issue in $file\n";
        $hasIssues = true;
    } else {
        echo "✓ Unary operators look good in " . basename($file) . "\n";
    }
}

echo "\n=== Step 3: Verifying migration class definitions ===\n";
$migrationFiles = array_filter($files, function($f) {
    return strpos($f, 'migrations') !== false;
});

foreach ($migrationFiles as $file) {
    $fullPath = $baseDir . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $file);
    $content = file_get_contents($fullPath);
    
    if (strpos($content, 'return new class extends Migration') !== false) {
        echo "✓ " . basename($file) . " uses anonymous class correctly\n";
    } else {
        echo "✗ " . basename($file) . " does not use anonymous class\n";
    }
}

echo "\n=== Step 4: Running Pint test mode on target files ===\n";
$fileList = implode(' ', array_map(function($f) use ($baseDir) {
    return '"' . $baseDir . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $f) . '"';
}, $files));

$cmd = "php vendor/bin/pint --test --verbose " . $fileList . " 2>&1";
echo "Command: $cmd\n\n";
system($cmd, $exitCode);

echo "\n=== Summary ===\n";
echo "Exit code: $exitCode\n";
echo "Pint test mode completed. 0 = all files comply, non-zero = issues found.\n";
?>
