<?php
// Format 8 specific PHP files

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

echo "Processing " . count($files) . " files...\n";

foreach ($files as $file) {
    $filePath = __DIR__ . '/' . $file;
    
    if (!file_exists($filePath)) {
        echo "✗ Missing: $file\n";
        continue;
    }
    
    $content = file_get_contents($filePath);
    $originalContent = $content;
    
    // Convert CRLF and CR to LF
    $content = str_replace("\r\n", "\n", $content);
    $content = str_replace("\r", "\n", $content);
    
    // Fix unary/not operator spacing for these patterns:
    // if(! -> if (!
    // etc.
    
    // Patterns to fix (ensure space after ! operator)
    $patterns = [
        '/if\s*\(\s*!(\s*)([^!])/' => 'if (! $2',  // if(! ... -> if (! ...
    ];
    
    foreach ($patterns as $pattern => $replacement) {
        $content = preg_replace($pattern, $replacement, $content);
    }
    
    if ($content !== $originalContent) {
        file_put_contents($filePath, $content);
        echo "✓ Fixed: $file\n";
    } else {
        echo "✓ Already OK: $file\n";
    }
}

echo "\nAll files processed.\n";
