#!/usr/bin/env python3
"""
Comprehensive file processing and Pint validation script
"""
import os
import sys
import subprocess
from pathlib import Path

base_dir = r'c:\Users\vectus\Desktop\SoutPro\Designet-LMS'
os.chdir(base_dir)

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

print("=" * 70)
print("STEP 1: Converting all files to LF line endings")
print("=" * 70)

for file_path in files:
    full_path = os.path.join(base_dir, file_path.replace('/', os.sep))
    
    if not os.path.exists(full_path):
        print(f"✗ File not found: {file_path}")
        continue
    
    try:
        with open(full_path, 'rb') as f:
            content = f.read()
        
        # Detect current line ending
        has_crlf = b'\r\n' in content
        has_cr_only = b'\r' in content and not has_crlf
        
        # Convert to LF
        content = content.replace(b'\r\n', b'\n')
        content = content.replace(b'\r', b'\n')
        
        with open(full_path, 'wb') as f:
            f.write(content)
        
        ending_str = "CRLF" if has_crlf else ("CR" if has_cr_only else "LF")
        print(f"✓ {os.path.basename(file_path):60s} ({ending_str} → LF)")
    except Exception as e:
        print(f"✗ Error processing {file_path}: {e}")

print("\n" + "=" * 70)
print("STEP 2: Verifying unary operator spacing")
print("=" * 70)

issues_found = False
for file_path in files:
    full_path = os.path.join(base_dir, file_path.replace('/', os.sep))
    
    try:
        with open(full_path, 'r', encoding='utf-8') as f:
            lines = f.readlines()
        
        file_issues = []
        for i, line in enumerate(lines, 1):
            # Look for ! followed by something other than space/whitespace
            # but allow != and !== and !$
            import re
            matches = re.findall(r'!\S', line)
            for match in matches:
                # Allow valid patterns
                if not any(pattern in match for pattern in ['!=', '!==', '!$', '!array', '!is', '!empty', '!isset', '!str', '!in_array', '!blank', '!function', '!class', '!interface', '!trait', '!method']):
                    file_issues.append((i, line.rstrip(), match))
        
        if file_issues:
            print(f"⚠ {os.path.basename(file_path)}: Found {len(file_issues)} potential spacing issue(s)")
            for line_num, line_text, match in file_issues[:3]:
                print(f"    Line {line_num}: {line_text[:70]}")
            issues_found = True
        else:
            print(f"✓ {os.path.basename(file_path):60s} - OK")
    except Exception as e:
        print(f"✗ Error checking {file_path}: {e}")

print("\n" + "=" * 70)
print("STEP 3: Verifying migration class definitions")
print("=" * 70)

migration_files = [f for f in files if 'migrations' in f]
for file_path in migration_files:
    full_path = os.path.join(base_dir, file_path.replace('/', os.sep))
    
    try:
        with open(full_path, 'r', encoding='utf-8') as f:
            content = f.read()
        
        if 'return new class extends Migration' in content:
            print(f"✓ {os.path.basename(file_path):60s} - Anonymous class OK")
        else:
            print(f"✗ {os.path.basename(file_path):60s} - Not an anonymous class!")
    except Exception as e:
        print(f"✗ Error checking {file_path}: {e}")

print("\n" + "=" * 70)
print("STEP 4: Running Pint test mode")
print("=" * 70)

quoted_files = [f'"{os.path.join(base_dir, f.replace("/", os.sep))}"' for f in files]
cmd = f'php vendor/bin/pint --test {" ".join(quoted_files)} 2>&1'

print(f"Executing: {cmd}\n")
try:
    result = subprocess.run(cmd, shell=True, capture_output=False, text=True)
    print(f"\nPint exit code: {result.returncode}")
except Exception as e:
    print(f"Error running Pint: {e}")

print("\n" + "=" * 70)
print("VALIDATION COMPLETE")
print("=" * 70)
