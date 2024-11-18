<?php

namespace App\Policies;

use App\Models\AlternatifModel;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AlternatifModelPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Misalnya, hanya admin yang dapat melihat daftar model Alternatif
        return $user->hasRole('admin');  // Sesuaikan dengan role atau izin yang sesuai
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AlternatifModel $alternatifModel): bool
    {
        // Pengguna dapat melihat model jika mereka adalah pemiliknya atau admin
        return $user->id === $alternatifModel->user_id || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Misalnya, hanya pengguna yang memiliki peran 'editor' atau 'admin' yang dapat membuat model
        return $user->hasRole('editor') || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, AlternatifModel $alternatifModel): bool
    {
        // Pengguna dapat memperbarui model jika mereka adalah pemiliknya atau admin
        return $user->id === $alternatifModel->user_id || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AlternatifModel $alternatifModel): bool
    {
        // Pengguna dapat menghapus model jika mereka adalah pemiliknya atau admin
        return $user->id === $alternatifModel->user_id || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, AlternatifModel $alternatifModel): bool
    {
        // Pengguna dapat mengembalikan model yang dihapus jika mereka adalah pemiliknya atau admin
        return $user->id === $alternatifModel->user_id || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, AlternatifModel $alternatifModel): bool
    {
        // Pengguna dapat menghapus model secara permanen jika mereka adalah pemiliknya atau admin
        return $user->id === $alternatifModel->user_id || $user->hasRole('admin');
    }
}
