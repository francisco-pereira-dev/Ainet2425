<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate; // <-- IMPORTANTE
use App\Models\User; // <-- IMPORTANTE

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // ADICIONA ISTO:
        Gate::define('isBoard', function (User $user) {
            return $user->type === 'board';
        });
    }
}

