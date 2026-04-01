#!/usr/bin/env python3
"""
Inline comprehensive file and Pint test mode runner
This script is designed to be runnable from any environment
"""

import os
import sys
import re
from pathlib import Path

def check_line_endings(content_bytes):
    """Check what line ending type is used"""
    has_crlf = b'\r\n' in content_bytes
    has_cr = b'\r' in content_bytes
    if has_crlf:
        return 'CRLF'
    elif has_cr:
        return 'CR'
    else:
        return 'LF'

def normalize_line_endings(content_bytes):
    """Convert to LF only"""
    # First convert CRLF to LF
    content_bytes = content_bytes.replace(b'\r\n', b'\n')
    # Then convert any remaining CR to LF
    content_bytes = content_bytes.replace(b'\r', b'\n')
    return content_bytes

base_dir = r'c:\Users\vectus\Desktop\SoutPro\Designet-LMS'

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

print("=" * 80)
print("STEP 1: ANALYZING FILES AND CONVERTING LINE ENDINGS")
print("=" * 80 + "\n")

for file_path in files_to_check:
    full_path = os.path.join(base_dir, file_path.replace('/', os.sep))
    filename = os.path.basename(file_path)
    
    if not os.path.exists(full_path):
        print(f"✗ {filename:50s} - FILE NOT FOUND")
        continue
    
    try:
        # Read as binary
        with open(full_path, 'rb') as f:
            content_bytes = f.read()
        
        # Check current line ending
        current_ending = check_line_endings(content_bytes)
        
        # Normalize to LF
        normalized_content = normalize_line_endings(content_bytes)
        
        # Write back
        with open(full_path, 'wb') as f:
            f.write(normalized_content)
        
        # Verify it's LF now
        final_ending = check_line_endings(normalized_content)
        
        status = f"({current_ending} → {final_ending})" if current_ending != final_ending else f"({final_ending})"
        print(f"✓ {filename:50s} {status}")
        
    except Exception as e:
        print(f"✗ {filename:50s} - ERROR: {e}")

print("\n" + "=" * 80)
print("STEP 2: CHECKING FOR UNARY OPERATOR ISSUES")
print("=" * 80 + "\n")

for file_path in files_to_check:
    full_path = os.path.join(base_dir, file_path.replace('/', os.sep))
    filename = os.path.basename(file_path)
    
    if not os.path.exists(full_path):
        continue
    
    try:
        with open(full_path, 'r', encoding='utf-8') as f:
            content = f.read()
            lines = content.split('\n')
        
        issues = []
        for i, line in enumerate(lines, 1):
            # Check for ! not followed by space or allowed operators
            # Pattern: ! followed by word character that's not part of !, !=, !==, !$, etc.
            matches = re.finditer(r'!\w', line)
            for m in matches:
                # Check if it's part of a valid compound
                context = line[max(0, m.start()-2):min(len(line), m.end()+2)]
                # These are OK: !=, !==, !$array, !function, etc.
                if not re.match(r'.*(!=|!==|\!\$).*', context):
                    issues.append((i, line.strip()[:70]))
        
        if issues:
            print(f"⚠ {filename:50s} - Found {len(issues)} potential spacing issue(s)")
            for line_num, line_text in issues[:2]:
                print(f"    Line {line_num}: {line_text}")
        else:
            print(f"✓ {filename:50s} - All unary operators OK")
            
    except Exception as e:
        print(f"✗ {filename:50s} - ERROR: {e}")

print("\n" + "=" * 80)
print("STEP 3: CHECKING MIGRATION CLASS DEFINITIONS")
print("=" * 80 + "\n")

for file_path in [f for f in files_to_check if 'migrations' in f]:
    full_path = os.path.join(base_dir, file_path.replace('/', os.sep))
    filename = os.path.basename(file_path)
    
    try:
        with open(full_path, 'r', encoding='utf-8') as f:
            content = f.read()
        
        if 'return new class extends Migration' in content:
            if content.rstrip().endswith('};'):
                print(f"✓ {filename:50s} - Anonymous class with proper closing")
            else:
                print(f"⚠ {filename:50s} - Anonymous class but check closing brace")
        else:
            print(f"✗ {filename:50s} - NOT an anonymous class!")
            
    except Exception as e:
        print(f"✗ {filename:50s} - ERROR: {e}")

print("\n" + "=" * 80)
print("STEP 4: ATTEMPTING TO RUN PINT TEST MODE")
print("=" * 80 + "\n")

# Try running pint
import subprocess

files_string = ' '.join([f'"{os.path.join(base_dir, f.replace("/", os.sep))}"' for f in files_to_check])
pint_cmd = f'php vendor/bin/pint --test {files_string}'

print(f"Command: {pint_cmd}\n")

try:
    result = subprocess.run(pint_cmd, shell=True, cwd=base_dir, capture_output=True, text=True)
    
    if result.stdout:
        print("STDOUT:")
        print(result.stdout)
    
    if result.stderr:
        print("STDERR:")
        print(result.stderr)
    
    print(f"\nExit Code: {result.returncode}")
    
    if result.returncode == 0:
        print("✓ All files pass Pint test mode!")
    else:
        print("✗ Some files have Pint violations")
        
except Exception as e:
    print(f"✗ Could not run Pint: {e}")
    print("   Make sure you're in the project directory with: cd " + base_dir)

print("\n" + "=" * 80)
print("REPORT COMPLETE")
print("=" * 80)
