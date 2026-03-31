<?php

namespace App\Enums;

enum RoleType: string
{
    case Admin = 'admin';
    case Formateur = 'formateur';
    case Etudiant = 'etudiant';
}
