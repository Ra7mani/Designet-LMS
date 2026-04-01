#!/usr/bin/env python3
import os
import sys

files = [
    'app/Livewire/Etudiant/QuizExamens.php',
    'app/Livewire/Formateur/MesEtudiants.php',
    'app/Livewire/Formateur/Quiz.php',
    'app/Models/Question.php',
    'app/Models/Quiz.php',
    'app/Models/QuizAttempt.php',
    'database/migrations/2026_03_31_231200_add_grading_columns_to_quiz_attempts.php',
    'database/migrations/2026_04_01_010000_add_quiz_exam_management_fields.php',
]

for file_path in files:
    full_path = os.path.join('c:\\Users\\vectus\\Desktop\\SoutPro\\Designet-LMS', file_path)
    try:
        # Read file in binary mode
        with open(full_path, 'rb') as f:
            content = f.read()
        
        # Convert CRLF to LF
        content = content.replace(b'\r\n', b'\n')
        # Remove any remaining CR
        content = content.replace(b'\r', b'\n')
        
        # Write back
        with open(full_path, 'wb') as f:
            f.write(content)
        
        print(f"✓ Converted {os.path.basename(file_path)} to LF")
    except Exception as e:
        print(f"✗ Error processing {file_path}: {e}")

print("\nDone!")
