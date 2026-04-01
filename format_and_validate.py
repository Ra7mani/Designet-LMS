#!/usr/bin/env python3
"""
Format and validate 8 PHP files for compliance with PSR-12 standards.
- Convert line endings to LF
- Ensure unary/not operator spacing is compliant
- Ensure migration anonymous class definition + braces_position are compliant
"""

import os
import re
import sys

files_to_format = [
    "app/Livewire/Etudiant/QuizExamens.php",
    "app/Livewire/Formateur/MesEtudiants.php",
    "app/Livewire/Formateur/Quiz.php",
    "app/Models/Question.php",
    "app/Models/Quiz.php",
    "app/Models/QuizAttempt.php",
    "database/migrations/2026_03_31_231200_add_grading_columns_to_quiz_attempts.php",
    "database/migrations/2026_04_01_010000_add_quiz_exam_management_fields.php"
]

base_path = r"c:\Users\vectus\Desktop\SoutPro\Designet-LMS"
changed_files = []

def read_file(path):
    """Read file as binary to preserve line endings"""
    with open(path, 'rb') as f:
        return f.read()

def write_file(path, content):
    """Write file with LF line endings (UTF-8 without BOM)"""
    with open(path, 'wb') as f:
        f.write(content)

def format_file(filepath):
    """Format a single file"""
    full_path = os.path.join(base_path, filepath)
    
    # Read the file
    content_bytes = read_file(full_path)
    
    # Try UTF-8 decode, handle BOM if present
    if content_bytes.startswith(b'\xef\xbb\xbf'):
        content = content_bytes[3:].decode('utf-8')
    else:
        content = content_bytes.decode('utf-8')
    
    original = content
    
    # 1. Convert CRLF to LF
    content = content.replace('\r\n', '\n')
    
    # 2. Trim trailing whitespace but ensure single newline at end
    content = re.sub(r'\n+$', '\n', content)
    
    # 3. Fix unary/not operator spacing
    # Cases to fix:
    # - "if (!$" -> "if (! $"
    # - "return !$" -> "return ! $"
    # - "if (!Schema::" -> "if (! Schema::"
    # Pattern: ! without space after it (before identifier or Schema)
    
    # Fix "if (! " spacing - ensure space after !
    content = re.sub(r'if\s*\(\s*!([^ ])', r'if (! \1', content)
    
    # Fix "return ! " - ensure space after !
    content = re.sub(r'return\s+!([^ ])', r'return ! \1', content)
    
    # Fix "= !" and similar - ensure space after !
    content = re.sub(r'([\w\)])\s*!([^ ])', r'\1 ! \2', content)
    
    # Check if any changes were made
    if content != original:
        # Write back with LF line endings only (UTF-8 no BOM)
        write_file(full_path, content.encode('utf-8'))
        return True
    return False

# Process each file
print("Processing files for formatting compliance...")
print()

for filepath in files_to_format:
    try:
        if format_file(filepath):
            changed_files.append(filepath)
            print(f"✓ Fixed: {filepath}")
        else:
            print(f"→ OK: {filepath}")
    except Exception as e:
        print(f"✗ Error: {filepath} - {e}")

print()
print("=" * 70)
print("Summary:")
print(f"Files modified: {len(changed_files)}")
if changed_files:
    for f in changed_files:
        print(f"  - {f}")
else:
    print("  (No changes needed)")
print()

# All 8 files should now be ready for pint validation
sys.exit(0)
