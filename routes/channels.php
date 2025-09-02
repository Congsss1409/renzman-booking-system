<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// *** NEW: Add authorization for our private admin dashboard channel ***
Broadcast::channel('admin-dashboard', function ($user) {
    // Only allow users that are not null (i.e., logged-in admins)
    return $user != null;
});
