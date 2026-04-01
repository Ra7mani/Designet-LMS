<?php

/**
 * Validation script for 8 PHP files formatting compliance
 */

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

echo "=== PHP Formatting Compliance Validation ===\n\n";
echo "Files to validate: " . count($files) . "\n";
echo str_repeat("-", 70) . "\n\n";

$issues = [];
$passedFiles = [];

foreach ($files as $file) {
    $filePath = __DIR__ . '/' . $file;
    
    if (!file_exists($filePath)) {
        $issues[$file] = ["File not found"];
        continue;
    }
    
    $content = file_get_contents($filePath);
    $fileIssues = [];
    
    // Check 1: LF line endings (no CRLF)
    if (strpos($content, "\r\n") !== false) {
        $fileIssues[] = "❌ Uses CRLF line endings instead of LF";
    }
    
    // Check 2: Unary operator spacing - ensure space after ! and before statement
    // Pattern: if(! should be if (!
    if (preg_match('/if\s*\(\s*!(?!\s)/', $content)) {
        $fileIssues[] = "❌ Unary operator spacing issue: if(! should be if (!";
    }
    
    // Check 3: Class declaration brace position
    // For anonymous classes in migrations, should be: new class extends X\n{
    if (strpos($file, 'migrations') !== false) {
        if (preg_match('/extends Migration\s*{/', $content)) {
            // This is OK for migrations (brace on same line for anonymous class is Pint-compliant)
            // Actually Pint prefers: new class extends Migration\n{
            if (!preg_match('/extends Migration\n\s*\{/', $content)) {
                $fileIssues[] = "❌ Migration class declaration should have brace on next line";
            }
        }
    }
    
    // Check 4: No trailing spaces
    foreach (explode("\n", $content) as $lineNum => $line) {
        if (preg_match('/\s+$/', rtrim($line, "\n"))) {
            $fileIssues[] = "❌ Trailing whitespace on line " . ($lineNum + 1);
            break;  // Report just first occurrence
        }
    }
    
    // Check 5: Proper line ending at end of file
    if (substr($content, -1) !== "\n") {
        $fileIssues[] = "❌ File should end with newline";
    }
    
    // Check 6: No mixed tabs and spaces
    if (preg_match('/\t/', $content)) {
        $fileIssues[] = "❌ Contains tabs instead of spaces";
    }
    
    if (empty($fileIssues)) {
        $passedFiles[] = $file;
        echo "✅ PASS: $file\n";
    } else {
        $issues[$file] = $fileIssues;
        echo "❌ FAIL: $file\n";
        foreach ($fileIssues as $issue) {
            echo "   $issue\n";
        }
    }
    echo "\n";
}

echo str_repeat("-", 70) . "\n\n";
echo "SUMMARY:\n";
echo "  Passed: " . count($passedFiles) . "/" . count($files) . "\n";
echo "  Failed: " . count($issues) . "/" . count($files) . "\n";

if (empty($issues)) {
    echo "\n✅ ALL FILES PASS FORMATTING CHECKS!\n";
    exit(0);
} else {
    echo "\n❌ Some files have formatting issues.\n";
    exit(1);
}
