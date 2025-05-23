<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Jadwal;

class JadwalPolicy
{
    /**
     * Determine whether the user can view any jadwal.
     */
    public function viewAny(User $user)
    {
        // Semua role boleh melihat daftar jadwal
        return true;
    }

    /**
     * Determine whether the user can view the jadwal.
     */
    public function view(User $user, Jadwal $jadwal)
    {
        // Semua role boleh melihat detail jadwal
        return true;
    }

    /**
     * Determine whether the user can create jadwal.
     */
    public function create(User $user)
    {
        // Hanya admin atau pengajar yang boleh create
        return in_array($user->role, ['admin', 'pengajar']);
    }

    /**
     * Determine whether the user can update the jadwal.
     */
    public function update(User $user, Jadwal $jadwal)
    {
        // Hanya admin atau pengajar yang boleh edit
        return in_array($user->role, ['admin', 'pengajar']);
    }

    /**
     * Determine whether the user can delete the jadwal.
     */
    public function delete(User $user, Jadwal $jadwal)
    {
        // Hanya admin atau pengajar yang boleh delete
        return in_array($user->role, ['admin', 'pengajar']);
    }
}
