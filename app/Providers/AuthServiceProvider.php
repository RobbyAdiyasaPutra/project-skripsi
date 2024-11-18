<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\AlternatifModel;  // Contoh model yang perlu dikaitkan dengan policy
use App\Models\CriteriaModel;    // Contoh model lainnya
use App\Policies\AlternatifModelPolicy;  // Kebijakan untuk AlternatifModel
use App\Policies\CriteriaModelPolicy;    // Kebijakan untuk CriteriaModel

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        AlternatifModel::class => AlternatifModelPolicy::class,
        CriteriaModel::class => CriteriaModelPolicy::class,
        // Tambahkan pemetaan model ke policy lainnya jika perlu
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Mendaftarkan kebijakan untuk model, sistem ini akan memeriksa hak akses pengguna untuk model tertentu
        $this->registerPolicies();

        // Anda bisa menambahkan gate untuk otorisasi kustom di sini
        Gate::define('view-any-criteria', function ($user) {
            return $user->hasRole('admin');  // Contoh otorisasi gate kustom
        });

        Gate::define('edit-criteria', function ($user, CriteriaModel $criteria) {
            return $user->id === $criteria->user_id;  // Cek apakah pengguna adalah pemilik
        });
    }
}
