<?php

namespace App\Policies;

use App\Models\CriteriaModel;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CriteriaModelPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Misalnya, hanya pengguna dengan peran 'admin' atau 'manager' yang dapat melihat daftar semua model
        return $user->hasRole('admin') || $user->hasRole('manager');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CriteriaModel $criteriaModel): bool
    {
        // Pengguna dapat melihat model jika mereka adalah pemiliknya atau memiliki peran 'admin'
        return $user->id === $criteriaModel->user_id || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Pengguna dapat membuat model jika mereka memiliki peran 'editor' atau 'admin'
        return $user->hasRole('editor') || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CriteriaModel $criteriaModel): bool
    {
        // Pengguna dapat memperbarui model jika mereka adalah pemiliknya atau memiliki peran 'admin'
        return $user->id === $criteriaModel->user_id || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CriteriaModel $criteriaModel): bool
    {
        // Pengguna dapat menghapus model jika mereka adalah pemiliknya atau memiliki peran 'admin'
        return $user->id === $criteriaModel->user_id || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CriteriaModel $criteriaModel): bool
    {
        // Pengguna dapat mengembalikan model yang dihapus jika mereka adalah pemiliknya atau memiliki peran 'admin'
        return $user->id === $criteriaModel->user_id || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CriteriaModel $criteriaModel): bool
    {
        // Pengguna dapat menghapus model secara permanen jika mereka adalah pemiliknya atau memiliki peran 'admin'
        return $user->id === $criteriaModel->user_id || $user->hasRole('admin');
    }
}
