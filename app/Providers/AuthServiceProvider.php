<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register authentication and authorization services.
     */
    public function boot(): void
    {
        Gate::define('dangky.review', function (User $user): bool {
            return $user->hasAnyRole([
                \App\Enums\UserRole::Admin,
            ]);
        });

        Gate::define('hopdong.manage', function (User $user): bool {
            return $user->hasAnyRole([
                \App\Enums\UserRole::Admin,
            ]);
        });

        Gate::define('hoadon.manage', function (User $user): bool {
            return $user->hasAnyRole([
                \App\Enums\UserRole::Admin,
            ]);
        });

        Gate::define('cauhinh.manage', function (User $user): bool {
            return $user->hasAnyRole([
                \App\Enums\UserRole::Admin,
            ]);
        });

        Gate::define('kyluat.manage', function (User $user): bool {
            return $user->hasAnyRole([
                \App\Enums\UserRole::Admin,
            ]);
        });

        Gate::define('phong.manage', function (User $user): bool {
            return $user->hasAnyRole([
                \App\Enums\UserRole::Admin,
            ]);
        });

        Gate::define('toanha.manage', function (User $user): bool {
            return $user->hasAnyRole([
                \App\Enums\UserRole::Admin,
            ]);
        });

        Gate::define('baohong.manage', function (User $user): bool {
            return $user->hasAnyRole([
                \App\Enums\UserRole::Admin,
            ]);
        });

        Gate::define('sinhvien.manage', function (User $user): bool {
            return $user->hasAnyRole([
                \App\Enums\UserRole::Admin,
            ]);
        });

        Gate::define('accounts.manage', function (User $user): bool {
            return $user->vaitro === \App\Enums\UserRole::Admin;
        });
    }
}
