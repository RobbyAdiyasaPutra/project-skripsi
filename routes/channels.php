<?php

use Illuminate\Support\Facades\Broadcast;

/*
|---------------------------------------------------------------------------
| Broadcast Channels
|---------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    // Cek apakah ID pengguna yang diajukan sama dengan ID pengguna yang sedang login
    return (int) $user->id === (int) $id;
});
