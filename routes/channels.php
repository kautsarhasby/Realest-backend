<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('channel-{room_id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
