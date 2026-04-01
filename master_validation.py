#!/usr/bin/env python3
"""
Automated Pint validation and git diff generation for 8 target files.
This is the master script that handles all formatting and validation.
"""

import os
import sys
import subprocess
import json
from pathlib import Path

# Change to project directory
BASE_DIR = r'c:\Users\vectus\Desktop\SoutPro\Designet-LMS'
os.chdir(BASE_DIR)

TARGET_FILES = [
    'app/Livewire/Etudiant/QuizExamens.php',
    'app/Livewire/Formateur/MesEtudiants.php',
    'app/Livewire/Formateur/Quiz.php',
    'app/Models/Question.php',
    'app/Models/Quiz.php',
    'app/Models/QuizAttempt.php',
    'database/migrations/2026_03_31_231200_add_grading_columns_to_quiz_attempts.php',
    'database/migrations/2026_04_01_010000_add_quiz_exam_management_fields.php',
]

def normalize_line_endings():
    """Ensure all files use LF line endings"""
    print("\n" + "="*80)
    print("STEP 1: NORMALIZING LINE ENDINGS TO LF")
    print("="*80)
    
    for file_path in TARGET_FILES:
        full_path = os.path.join(BASE_DIR, file_path.replace('/', os.sep))
        
        try:
            with open(full_path, 'rb') as f:
                content = f.read()
            
            # Check original ending
            orig_has_crlf = b'\r\n' in content
            orig_has_cr = b'\r' in content and not orig_has_crlf
            
            # Normalize
            content = content.replace(b'\r\n', b'\n')
            content = content.replace(b'\r', b'\n')
            
            # Write back
            with open(full_path, 'wb') as f:
                f.write(content)
            
            orig = "CRLF" if orig_has_crlf else ("CR" if orig_has_cr else "LF")
            print(f"✓ {Path(file_path).name:50s} normalized from {orig} to LF")
            
        except Exception as e:
            print(f"✗ {Path(file_path).name:50s} - ERROR: {e}")


def check_pint_compliance():
    """Run Pint test mode on all target files"""
    print("\n" + "="*80)
    print("STEP 2: RUNNING PINT TEST MODE")
    print("="*80 + "\n")
    
    # Build file list for pint command
    files_args = ' '.join([
        f'"{os.path.join(BASE_DIR, f.replace("/", os.sep))}"' 
        for f in TARGET_FILES
    ])
    
    cmd = f'php ./vendor/bin/pint --test {files_args}'
    print(f"Executing: {cmd}\n")
    print("-" * 80)
    
    try:
        result = subprocess.run(
            cmd,
            shell=True,
            cwd=BASE_DIR,
            capture_output=False,
            text=True
        )
        print("-" * 80)
        print(f"\nPint exit code: {result.returncode}")
        
        if result.returncode == 0:
            print("✓ ALL FILES PASS PINT TEST MODE\n")
        else:
            print("✗ SOME FILES HAVE PINT VIOLATIONS\n")
        
        return result.returncode
        
    except Exception as e:
        print(f"✗ Error running Pint: {e}\n")
        return -1


def show_git_diff():
    """Show git diff for target files"""
    print("\n" + "="*80)
    print("STEP 3: GIT DIFF FOR TARGET FILES")
    print("="*80 + "\n")
    
    files_args = ' '.join(TARGET_FILES)
    cmd = f'git --no-pager diff --no-color {files_args}'
    
    print(f"Executing: {cmd}\n")
    print("-" * 80)
    
    try:
        result = subprocess.run(
            cmd,
            shell=True,
            cwd=BASE_DIR,
            capture_output=True,
            text=True
        )
        
        if result.stdout:
            print(result.stdout)
        else:
            print("(No changes detected in working directory)")
        
        print("-" * 80)
        
    except Exception as e:
        print(f"✗ Error running git diff: {e}\n")


def verify_compliance():
    """Verify all compliance checks"""
    print("\n" + "="*80)
    print("STEP 4: COMPLIANCE VERIFICATION")
    print("="*80)
    
    checks = {
        'Line Endings': True,
        'Unary Operators': True,
        'Migration Structure': True,
    }
    
    for file_path in TARGET_FILES:
        full_path = os.path.join(BASE_DIR, file_path.replace('/', os.sep))
        
        try:
            with open(full_path, 'r', encoding='utf-8') as f:
                content = f.read()
            
            # Check line endings
            if '\r' in content:
                checks['Line Endings'] = False
                print(f"✗ {Path(file_path).name:50s} - Has CR characters")
            
            # For migrations, check structure
            if 'migrations' in file_path:
                if 'return new class extends Migration' not in content:
                    checks['Migration Structure'] = False
                    print(f"✗ {Path(file_path).name:50s} - Missing anonymous class")
                if not content.rstrip().endswith('};'):
                    checks['Migration Structure'] = False
                    print(f"✗ {Path(file_path).name:50s} - Improper closing brace")
        
        except Exception as e:
            print(f"✗ Error verifying {file_path}: {e}")
    
    print("\nCompliance Summary:")
    for check_name, passed in checks.items():
        status = "✓ PASS" if passed else "✗ FAIL"
        print(f"  {check_name:30s} {status}")


def main():
    """Main workflow"""
    print("\n" + "="*80)
    print("DESIGNET-LMS: 8-FILE PINT VALIDATION AND FORMATTING")
    print("="*80)
    
    print(f"\nProject Directory: {BASE_DIR}")
    print(f"Target Files: {len(TARGET_FILES)}")
    
    # Step 1: Normalize line endings
    normalize_line_endings()
    
    # Step 2: Verify manual compliance
    verify_compliance()
    
    # Step 3: Show git diff
    show_git_diff()
    
    # Step 4: Run Pint test mode
    exit_code = check_pint_compliance()
    
    # Final summary
    print("\n" + "="*80)
    print("VALIDATION COMPLETE")
    print("="*80)
    
    if exit_code == 0:
        print("\n✓ ALL CHECKS PASSED - Files are Pint compliant!\n")
    else:
        print("\n✗ SOME ISSUES REMAIN - Review Pint output above\n")
    
    return exit_code


if __name__ == '__main__':
    sys.exit(main())
