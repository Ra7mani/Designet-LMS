<?php

namespace App\Providers;

use App\Enums\RoleType;
use App\Models\Certificat;
use App\Models\Inscription;
use App\Observers\CertificatObserver;
use App\Observers\InscriptionObserver;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Laravel\Fortify\Fortify;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->configureDefaults();
        $this->configureFortify();

        Inscription::observe(InscriptionObserver::class);
        Certificat::observe(CertificatObserver::class);
    }

    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }

    protected function configureFortify(): void
    {
        Fortify::redirects('login', function () {
            $user = auth()->user();

            return match ($user->role) {
                RoleType::Admin => route('admin.dashboard'),
                RoleType::Formateur => route('formateur.dashboard'),
                RoleType::Etudiant => route('etudiant.dashboard'),
                default => route('etudiant.dashboard'),
            };
        });
    }
}
