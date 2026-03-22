# 🧪 DESIGNET-LMS - Testing Guide

## Prerequisites
```bash
# Make sure Laravel is running
php artisan serve          # http://localhost:8000
php artisan tinker         # For quick testing if needed
```

---

## 📋 GENERAL FEATURES

### ✅ 1. **Login Page**
**File**: `resources/views/pages/auth/login.blade.php`

- [ ] Launch http://localhost:8000/login
- [ ] Verify theme (Flux components, purple gradient)
- [ ] Test email/password validation
- [ ] Test "Remember me" checkbox
- [ ] Test "Forgot password?" link
- [ ] Try login with valid credentials
- [ ] Check navbar shows user profile after login
- [ ] **Result**: ___________

---

### ✅ 2. **Register Page**
**File**: `resources/views/pages/auth/register.blade.php`

- [ ] Go to http://localhost:8000/register
- [ ] Verify same theme as login
- [ ] Test role selection (Etudiant/Formateur/Admin)
- [ ] Test email validation
- [ ] Test password strength (min 8 chars, etc)
- [ ] Complete register as student
- [ ] Verify email confirmation flow (check console/DB)
- [ ] **Result**: ___________

---

### ✅ 3. **Password Reset**
**File**: `resources/views/pages/auth/forgot-password.blade.php`

- [ ] Go to http://localhost:8000/forgot-password
- [ ] Request password reset with valid email
- [ ] Check if reset link is in Laravel logs (or DB table `password_reset_tokens`)
- [ ] Try reset link
- [ ] Create new password
- [ ] Login with new password
- [ ] **Result**: ___________

---

### ✅ 4. **Page Protection & Redirects**
**Flow**: Non-authenticated users should redirect to login

- [ ] Logout: Click profile → Logout btn (or POST /logout)
- [ ] Try to access http://localhost:8000/etudiant/dashboard
- [ ] **Expected**: Redirects to login page
- [ ] Try to access http://localhost:8000/admin/dashboard as student
- [ ] **Expected**: Redirects to 403 Forbidden or dashboard
- [ ] **Result**: ___________

---

## 🏫 STUDENT FEATURES

### ✅ 5. **Catalogue de Cours**
**File**: `app/Livewire/Etudiant/Catalogue.php` + `resources/views/livewire/etudiant/catalogue.blade.php`

- [ ] Login as student
- [ ] Navigate to http://localhost:8000/etudiant/catalogue
- [ ] **Search**: Type in search box → courses filter ✓
- [ ] **Category Filter**: Select a category → results update ✓
- [ ] **Level Filter**: Select level → results update ✓
- [ ] **Pagination**: Navigate through pages if > 12 courses ✓
- [ ] Click course card → goes to detail page ✓
- [ ] **Result**: ___________

---

### ✅ 6. **Course Detail & Enrollment**
**File**: `app/Livewire/Etudiant/DetailCours.php`

- [ ] Choose a published course from catalogue
- [ ] Verify displays: title, instructor, rating, students count
- [ ] Check course structure (chapters, lessons, quizzes)
- [ ] Click "S'inscrire" (Enroll)
- [ ] Verify status changes to "Accéder au cours"
- [ ] Try enrolling again → should prevent duplicate
- [ ] Leave review: click "Laisser un avis" → test rating + comment
- [ ] **Result**: ___________

---

### ✅ 7. **Loading Spinners (Livewire)**
**Looking for**: `wire:loading.delay` animations

**Check these pages**:
- [ ] Catalogue: Search input → should show spinner while filtering
- [ ] DetailCours: Enroll button → should show spinner
- [ ] Quiz: While submitting answers → spinner visible?
- [ ] Profile: Avatar upload → spinner during upload?
- **Issue**: If no spinners → needs implementation
- [ ] **Result**: ___________

---

### ✅ 8. **Error Messages**
**Test API/Livewire error handling**:

- [ ] Try login with wrong password → error message shown?
- [ ] Submit incomplete form → validation errors shown?
- [ ] Try enrolling without auth → error message?
- [ ] Check console for JS errors
- **Issue**: If no error messages → needs implementation
- [ ] **Result**: ___________

---

### ✅ 9. **Course Player/Lessons**
**CRITICAL - Check if implemented**:

- [ ] Go to "Mes Cours" → http://localhost:8000/etudiant/mes-cours
- [ ] Click on enrolled course
- [ ] **LOOKING FOR**: Video player / Lesson content
  - [ ] Does lesson show video? (HTML5 player, YouTubeIframe, etc)
  - [ ] Can play/pause?
  - [ ] Shows duration?
  - [ ] Auto-resumes from last position?
  - [ ] Shows progress bar?
- **If NO video player**: ❌ MISSING - Needs to be built
- [ ] **Result**: ___________

---

### ✅ 10. **XP Auto-Award System**
**File**: `app/Services/GamificationService.php`

**Test XP allocation on lesson/quiz completion**:

- [ ] Check profile → view current XP
- [ ] Complete a lesson (watch 80%+)
- [ ] Check profile again → XP increased?
- [ ] Take a quiz → pass it
- [ ] Check profile → XP increased again?
- [ ] Check badges page → any badge earned?
- **Trigger completion**: Update DB manually if needed
  ```sql
  UPDATE inscriptions SET progress = 100, status = 'completed'
  WHERE etudiant_id = 1;
  ```
- [ ] **Result**: ___________

---

### ✅ 11. **Mobile Menu - Hamburger**
**File**: `resources/views/layouts/etudiant.blade.php`

**Test on mobile (or resize browser)**:

- [ ] Resize window to < 768px (mobile)
- [ ] Hamburger button appears?
- [ ] Click hamburger → sidebar opens/closes smoothly?
- [ ] Can navigate via mobile menu?
- [ ] Menu closes when clicking a link?
- [ ] Styling is consistent?
- [ ] **Result**: ___________

---

### ✅ 12. **Dashboard & Gamification**
**File**: `app/Livewire/Etudiant/Dashboard.php`

- [ ] Login and view dashboard
- [ ] XP display correct? (reads from DB)
- [ ] Level calculation correct? (XP / 500 + 1)
- [ ] Badges section shows earned badges?
- [ ] Current course card displays progress?
- [ ] Leaderboard shows top students by XP?
- [ ] **Result**: ___________

---

## 🎨 THEME CONSISTENCY

### Visual Check on ALL pages:
- [ ] **Colors**: Purple gradient (#7C3AED) as primary throughout
- [ ] **Components**: Uses Flux components (buttons, inputs, cards)
- [ ] **Typography**: Poppins for titles, DM Sans for body
- [ ] **Spacing**: Consistent padding/gaps (14px, 16px, 28px, 30px)
- [ ] **Shadows**: Uses CSS var(--sh) for consistent shadows
- [ ] **Dark Mode**: Check if dark mode CSS is applied (if enabled)
- [ ] **Responsive**: No layout breaks on resize
- [ ] **Result**: ___________

---

## 📊 Test Results Summary

| Feature | Status | Notes |
|---------|--------|-------|
| Login Page | ☐ PASS / ☐ FAIL | ______________ |
| Register Page | ☐ PASS / ☐ FAIL | ______________ |
| Password Reset | ☐ PASS / ☐ FAIL | ______________ |
| Page Protection | ☐ PASS / ☐ FAIL | ______________ |
| Catalogue Filters | ☐ PASS / ☐ FAIL | ______________ |
| Course Detail | ☐ PASS / ☐ FAIL | ______________ |
| Loading Spinners | ☐ PASS / ☐ FAIL | **ACTION**: _______ |
| Error Messages | ☐ PASS / ☐ FAIL | **ACTION**: _______ |
| Video Player | ☐ PASS / ☐ FAIL | **ACTION**: _______ |
| XP Auto-Award | ☐ PASS / ☐ FAIL | **ACTION**: _______ |
| Hamburger Menu | ☐ PASS / ☐ FAIL | **ACTION**: _______ |
| Theme Consistency | ☐ PASS / ☐ FAIL | **ACTION**: _______ |

---

## 🔧 Quick DB Queries for Testing

```sql
-- Create test user (Student)
INSERT INTO users (name, email, password, role, email_verified_at)
VALUES ('Test Student', 'test@example.com', bcrypt('password123'), 'etudiant', NOW());

-- Mark course as published
UPDATE cours SET status = 'published' WHERE id = 1;

-- Mark enrollment as completed for XP testing
UPDATE inscriptions SET progress = 100, status = 'completed'
WHERE etudiant_id = 1 AND cours_id = 1;

-- Check XP calculation
SELECT id, name,
  (SELECT SUM(...) FROM ...) as xp
FROM users WHERE role = 'etudiant';
```

---

## 📝 Notes for Implementation

**MISSING/TO-DO**:
1. Video player component - **NOT FOUND**
2. Loading spinners - **Check if visible**
3. Error messages - **Check consistency**
4. Mobile responsive - **Test carefully**

---

**Start testing now and fill in the checkboxes! 👇**
