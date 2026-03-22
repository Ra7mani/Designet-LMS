<?php

namespace Database\Seeders;

use App\Enums\RoleType;
use App\Models\Categorie;
use App\Models\Cours;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Users
        $admin = User::create([
            'name'     => 'Admin',
            'email'    => 'admin@designet.com',
            'password' => Hash::make('password'),
            'role'     => RoleType::Admin,
        ]);

        $formateur = User::create([
            'name'     => 'Formateur Test',
            'email'    => 'formateur@designet.com',
            'password' => Hash::make('password'),
            'role'     => RoleType::Formateur,
        ]);

        User::create([
            'name'     => 'Etudiant Test',
            'email'    => 'etudiant@designet.com',
            'password' => Hash::make('password'),
            'role'     => RoleType::Etudiant,
        ]);

        // Catégories
        $dev = Categorie::create(['name' => 'Développement Web', 'description' => 'HTML, CSS, JS, PHP']);
        $design = Categorie::create(['name' => 'Design', 'description' => 'UI/UX, Figma, Adobe']);
        $data = Categorie::create(['name' => 'Data Science', 'description' => 'Python, ML, IA']);

        // Cours
        Cours::create([
            'formateur_id'  => $formateur->id,
            'categorie_id'  => $dev->id,
            'title'         => 'Laravel pour débutants',
            'description'   => 'Apprenez Laravel de zéro et créez des applications web modernes.',
            'price'         => 0,
            'level'         => 'debutant',
            'status'        => 'published',
        ]);

        Cours::create([
            'formateur_id'  => $formateur->id,
            'categorie_id'  => $dev->id,
            'title'         => 'React JS Avancé',
            'description'   => 'Maîtrisez React avec les hooks, Redux et les bonnes pratiques.',
            'price'         => 49.99,
            'level'         => 'avance',
            'status'        => 'published',
        ]);

        Cours::create([
            'formateur_id'  => $formateur->id,
            'categorie_id'  => $design->id,
            'title'         => 'UI/UX Design avec Figma',
            'description'   => 'Créez des interfaces modernes et intuitives avec Figma.',
            'price'         => 29.99,
            'level'         => 'intermediaire',
            'status'        => 'published',
        ]);

        Cours::create([
            'formateur_id'  => $formateur->id,
            'categorie_id'  => $data->id,
            'title'         => 'Python pour la Data Science',
            'description'   => 'Analysez des données avec Python, Pandas et Matplotlib.',
            'price'         => 39.99,
            'level'         => 'intermediaire',
            'status'        => 'published',
        ]);

        // Events & Sessions
        $this->call(EventSeeder::class);
    }
}