#!/usr/bin/env python3
"""
INLINE COMPREHENSIVE VALIDATION - No external dependencies beyond Python stdlib
Execute this from the project root: python3 final_check.py
"""

import os
import sys
import subprocess
from pathlib import Path

os.chdir(r'c:\Users\vectus\Desktop\SoutPro\Designet-LMS')

files_to_check = [
    'app/Livewire/Etudiant/QuizExamens.php',
    'app/Livewire/Formateur/MesEtudiants.php',
    'app/Livewire/Formateur/Quiz.php',
    'app/Models/Question.php',
    'app/Models/Quiz.php',
    'app/Models/QuizAttempt.php',
    'database/migrations/2026_03_31_231200_add_grading_columns_to_quiz_attempts.php',
    'database/migrations/2026_04_01_010000_add_quiz_exam_management_fields.php',
]

print("\n╔════════════════════════════════════════════════════════════════════════════╗")
print("║  DESIGNET-LMS: 8-FILE FINAL VALIDATION & PINT TEST MODE                   ║")
print("╚════════════════════════════════════════════════════════════════════════════╝\n")

print("Step 1: CONVERTING FILES TO LF LINE ENDINGS")
print("─" * 80)

conversions_made = 0
for file_path in files_to_check:
    full_path = Path(file_path)
    filename = full_path.name
    
    if not full_path.exists():
        print(f"  ✗ {filename:55s} [FILE NOT FOUND]")
        continue
    
    try:
        with open(full_path, 'rb') as f:
            content = f.read()
        
        # Detect line ending
        is_crlf = b'\r\n' in content
        is_cr = b'\r' in content and not is_crlf
        
        # Convert to LF
        original_size = len(content)
        content_lf = content.replace(b'\r\n', b'\n').replace(b'\r', b'\n')
        
        # Write back if changed
        if content_lf != content:
            with open(full_path, 'wb') as f:
                f.write(content_lf)
            conversions_made += 1
            ending = "CRLF" if is_crlf else ("CR" if is_cr else "LF")
            print(f"  ✓ {filename:55s} [{ending} → LF] ({original_size} bytes)")
        else:
            print(f"  ✓ {filename:55s} [LF] (already normalized)")
            
    except Exception as e:
        print(f"  ✗ {filename:55s} [ERROR: {str(e)[:30]}]")

print(f"\n  Conversions made: {conversions_made} file(s)\n")

print("Step 2: VERIFYING COMPLIANCE RULES")
print("─" * 80)

migration_files = [f for f in files_to_check if 'migrations' in f]
other_files = [f for f in files_to_check if 'migrations' not in f]

# Check migrations
print("\n  Migration Files:")
for file_path in migration_files:
    full_path = Path(file_path)
    filename = full_path.name
    
    with open(full_path, 'r', encoding='utf-8') as f:
        content = f.read()
    
    checks = []
    checks.append(('Anonymous class', 'return new class extends Migration' in content))
    checks.append(('Proper closing', content.rstrip().endswith('};')))
    checks.append(('No CR chars', '\r' not in content))
    checks.append(('Unary spacing', '! Schema::' in content))  # Verify ! with space
    
    all_ok = all(check[1] for check in checks)
    status = "✓" if all_ok else "✗"
    print(f"    {status} {filename}")
    for check_name, check_passed in checks:
        icon = "✓" if check_passed else "✗"
        print(f"       {icon} {check_name}")

# Check other files
print("\n  Livewire & Model Files:")
for file_path in other_files:
    full_path = Path(file_path)
    filename = full_path.name
    
    with open(full_path, 'r', encoding='utf-8') as f:
        content = f.read()
    
    checks = []
    checks.append(('No CR chars', '\r' not in content))
    checks.append(('Valid PHP', content.startswith('<?php')))
    checks.append(('Proper closing', content.rstrip().endswith('}')))
    
    all_ok = all(check[1] for check in checks)
    status = "✓" if all_ok else "✗"
    print(f"    {status} {filename}")

print("\n" + "─" * 80)
print("Step 3: GIT STATUS CHECK")
print("─" * 80 + "\n")

try:
    result = subprocess.run(
        ['git', '--no-pager', 'diff', '--stat'] + files_to_check,
        capture_output=True,
        text=True,
        cwd=r'c:\Users\vectus\Desktop\SoutPro\Designet-LMS'
    )
    
    if result.stdout:
        print("Changes detected:")
        for line in result.stdout.strip().split('\n'):
            if line:
                print(f"  {line}")
    else:
        print("  No changes detected in working tree")
        
except Exception as e:
    print(f"  Warning: Could not check git status: {e}")

print("\n" + "─" * 80)
print("Step 4: PINT TEST MODE EXECUTION")
print("─" * 80 + "\n")

# Build Pint command
pint_cmd = ['php', 'vendor/bin/pint', '--test'] + files_to_check

print(f"Executing Pint: php vendor/bin/pint --test [8 files]\n")

try:
    result = subprocess.run(
        pint_cmd,
        cwd=r'c:\Users\vectus\Desktop\SoutPro\Designet-LMS',
        capture_output=False,
        text=True
    )
    
    pint_exit_code = result.returncode
    
except Exception as e:
    print(f"✗ Error running Pint: {e}")
    pint_exit_code = -1

print("\n" + "═" * 80)
print("FINAL VALIDATION RESULT")
print("═" * 80 + "\n")

if pint_exit_code == 0:
    print("  ✓ ALL FILES PASS PINT TEST MODE")
    print("  ✓ All 8 files are Pint-compliant with Laravel preset")
    print("  ✓ Formatting is complete and validated")
    print("\n  Status: SUCCESS\n")
else:
    print(f"  ✗ Pint exited with code {pint_exit_code}")
    print("  Please review the Pint output above for details")
    print("\n  Status: REVIEW NEEDED\n")

print("═" * 80 + "\n")
