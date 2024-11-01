<?php

use App\Models\File;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

/**
 * Autorización para acceder al canal privado
 */
Broadcast::channel('compress-files-channel-{userId}', function (int $userId) {
    return true;
    // return $file->user_id === User::findOrNew($userId)->id;
});