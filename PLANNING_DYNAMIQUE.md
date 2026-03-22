# 📅 Planning Dynamique - Implémentation Complète

## ✅ Ce qui a été fait

La page **Planning** a été entièrement transformée pour devenir **100% dynamique** et puller les données de la base de données en temps réel.

### 1. **Modèles créés** (Models)
- **Event** (`app/Models/Event.php`) - Événements du calendrier
- **Session** (`app/Models/Session.php`) - Sessions de cours schedulées

### 2. **Migrations créées** (Database)
- `2026_03_19_005944_create_sessions_table.php` - Table `course_sessions`
- `2026_03_19_005945_create_events_table.php` - Table `events`

**Schéma des tables:**

#### `course_sessions`
```sql
- id
- title (String)
- description (Text, nullable)
- start_time (DateTime)
- end_time (DateTime)
- status (String: scheduled, in_progress, completed)
- cours_id (FK)
- formateur_id (FK)
- virtual_room_link (String, nullable)
- max_attendees (Integer)
- timestamps
```

#### `events`
```sql
- id
- title (String)
- description (Text, nullable)
- start_date (DateTime)
- end_date (DateTime)
- event_type (String: session, exam, course)
- location (String, nullable)
- session_id (FK, nullable)
- quiz_id (FK, nullable)
- cours_id (FK, nullable)
- created_by (FK)
- timestamps
```

### 3. **Composant Livewire créé**
**Fichier:** `app/Livewire/Etudiant/Planning.php`

**Fonctionnalités:**
- Gestion du mois courant (navigation prev/next)
- Récupération dynamique des événements d'aujourd'hui
- Récupération dynamique des événements de cette semaine
- Génération dynamique du calendrier avec marqueurs d'événements
- Computed properties pour les performances

**Propriétés publiques:**
```php
public int $currentMonth
public int $currentYear
public ?int $selectedEventId = null
```

**Computed Properties:**
```php
#[Computed] todayEvents        // Événements du jour
#[Computed] thisWeekEvents     // Événements de cette semaine (hors aujourd'hui)
#[Computed] calendarDays       // Jours du calendrier avec marqueurs
```

**Méthodes:**
```php
previousMonth()        // Mois précédent
nextMonth()           // Mois suivant
selectEvent()         // Sélectionner un événement
```

### 4. **Vue Blade mise à jour**
**Fichier:** `resources/views/livewire/etudiant/planning.blade.php`

**Changements:**
- ❌ Suppression du hardcoding statique
- ✅ Remplacement par des boucles Blade utilisant les données du composant
- ✅ Affichage dynamique des événements avec heure, titre, course
- ✅ Badges de type d'événement (Session, Examen, Cours)
- ✅ Calendrier dynamique avec marqueurs d'événements
- ✅ Sections "Aujourd'hui" et "Cette semaine" dynamiques

**Section "Cette semaine" avant (STATIQUE):**
```blade
<div class="event-item">
  <div class="event-time">10:00</div>
  <div class="event-info">
    <div class="event-name">Session Live: UX Design</div>
    <div class="event-course">UX/UI Design Avancé</div>
  </div>
  <span class="event-badge" style="background:var(--v);">Live</span>
</div>
```

**Section "Cette semaine" après (DYNAMIQUE):**
```blade
@foreach($this->thisWeekEvents as $event)
  <div class="event-item" wire:click="selectEvent({{ $event->id }})">
    <div class="event-time">{{ $event->start_date->format('H:i') }}</div>
    <div class="event-info">
      <div class="event-name">{{ $event->title }}</div>
      <div class="event-course">{{ $event->cours->title }}</div>
    </div>
    <span class="event-badge" style="background: @switch($event->event_type)
      @case('session') var(--v) @break
      @case('exam') var(--err) @break
      @case('course') #9333ea @break
      @endswitch;">
      ...
    </span>
  </div>
@endforeach
```

### 5. **Route mise à jour**
**Fichier:** `routes/etudiant.php`

**Avant:**
```php
Route::get('/planning', fn() => view('livewire.etudiant.planning'))->name('planning');
```

**Après:**
```php
use App\Livewire\Etudiant\Planning;

Route::get('/planning', Planning::class)->name('planning');
```

### 6. **Données de test créées**
**Fichier:** `database/seeders/EventSeeder.php`

Le seeder crée automatiquement:
- 3 sessions de cours (today et cette semaine)
- 3 événements correspondants
- Dates réalistes avec heures variées
- Liens de salles virtuelles Jitsi

### 7. **Database Seeder mis à jour**
**Fichier:** `database/seeders/DatabaseSeeder.php`

Ajout de l'appel au EventSeeder pour générer les données test.

---

## 🎯 Résultats

### ✅ Avant (STATIQUE)
- ❌ Contenu hardcodé en HTML
- ❌ Les mêmes 2 événements s'affichaient toujours
- ❌ Pas d'interaction avec la base de données
- ❌ Calendrier sans vrais événements

### ✅ Après (DYNAMIQUE)
- ✅ **100% dynamique** - Les données viennent de la base de données
- ✅ **Temps réel** - Tout s'actualise via Livewire
- ✅ **Interactif** - Clic sur les événements
- ✅ **Calendrier vivant** - Marqueurs pour chaque jour avec événement
- ✅ **Navigation** - Utilisateur peut naviguer entre les mois
- ✅ **Séparation** - "Aujourd'hui" et "Cette semaine" distinctes

---

## 🧪 Tests

### Option 1: Voir les données de test (Recommandé)
Les données de test ont été créées automatiquement lors de `php artisan migrate:fresh --seed`.

**Événements actuels:**
- **Aujourd'hui à 10:00** - Session Live: UX Design
- **Dans 2 jours à 14:30** - Atelier: JavaScript Avancé
- **Dans 4 jours à 18:00** - Séance Q&A: Frameworks

### Option 2: Accéder à la page
```
URL: http://127.0.0.1:8000/etudiant/planning
```

Vous verrez:
1. ✅ **Calendrier dynamique** avec marqueurs sur les jours avec événements
2. ✅ **Section "Aujourd'hui"** avec l'événement d'aujourd'hui
3. ✅ **Section "Cette semaine"** avec les événements futurs
4. ✅ **Navigation** - Boutons Précédent/Suivant pour naviguer mois par mois

### Option 3: Ajouter vos propres événements
```bash
cd c:\Users\vectus\Desktop\SoutPro\Designet-LMS
php artisan tinker
```

```php
// Créer une session
$session = App\Models\Session::create([
    'title' => 'Ma Session',
    'description' => 'Description',
    'start_time' => now()->addDays(1)->setHour(15),
    'end_time' => now()->addDays(1)->setHour(17),
    'status' => 'scheduled',
    'cours_id' => 1,
    'formateur_id' => 2,
    'virtual_room_link' => 'https://meet.jitsi.org/ma-session',
]);

// Créer l'événement correspondant
App\Models\Event::create([
    'title' => $session->title,
    'description' => $session->description,
    'start_date' => $session->start_time,
    'end_date' => $session->end_time,
    'event_type' => 'session',
    'location' => 'Salle Virtuelle',
    'session_id' => $session->id,
    'created_by' => 2,
]);

exit;
```

**Puis rafraîchir le navigateur** (F5) - Les nouve événements s'affichent instantanément! ✨

---

## 🔧 Architecture

### Flow du composant Livewire

```
Planning Component
├── mount() - Initialiser le mois courant
├── todayEvents (Computed) - Query: today's events
├── thisWeekEvents (Computed) - Query: this week's events
├── calendarDays (Computed) - Generate calendar grid
└── Blade View
    ├── Calendar (dynamique)
    ├── Today's Events (dynamique)
    └── This Week's Events (dynamique)
```

### Requêtes à la base de données

```php
// Today's Events
Event::whereBetween('start_date', [
    now()->startOfDay(),
    now()->endOfDay()
])->orderBy('start_date')->get()

// This Week's Events
Event::whereBetween('start_date', [
    now()->startOfWeek(),
    now()->endOfWeek()
])
->whereNot('start_date', 'between', [now()->startOfDay(), now()->endOfDay()])
->orderBy('start_date')->get()

// Calendar Days with Events
Event::whereDate('start_date', $date->toDateString())->exists()
```

---

## 📊 Fichiers modifiés/créés

### ✅ Créés
- `app/Models/Event.php` - Model
- `app/Models/Session.php` - Model
- `app/Livewire/Etudiant/Planning.php` - Component Livewire
- `database/migrations/2026_03_19_005944_create_sessions_table.php`
- `database/migrations/2026_03_19_005945_create_events_table.php`
- `database/seeders/EventSeeder.php`

### ✅ Modifiés
- `resources/views/livewire/etudiant/planning.blade.php` - Vue (100% dynamique)
- `routes/etudiant.php` - Route
- `database/seeders/DatabaseSeeder.php` - Include EventSeeder

---

## 🚀 Prochaines étapes (Optionnel)

1. **Modal de détails** - Créer un modal pour afficher les détails complets d'un événement
2. **Édition** - Permettre aux admins d'éditer les événements
3. **Suppression** - Permettre la suppression des événements
4. **Notifications** - Notifier l'étudiant 24h avant un événement
5. **Synchronisation iCal** - Export en fichier .ics
6. **Couleurs** - Plus de couleurs par type de cours
7. **Filtrage** - Filtrer par cours, type d'événement, etc.

---

## ✨ Résumé

La section **"Cette semaine"** de la page planning est maintenant:
- ✅ **100% dynamique**
- ✅ **Liée à la base de données**
- ✅ **En temps réel**
- ✅ **Extensible**
- ✅ **Performante**

**Plus de données STATIQUES! 🎉**
