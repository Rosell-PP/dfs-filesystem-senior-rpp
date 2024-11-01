<?php

use App\Models\File;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

/**
 * Autorización para acceder al canal privado
 */
Broadcast::channel('compress-files-channel.{fileId}', function (User $user, int $fileId) {
    return $user->id === File::findOrNew($fileId)->user_id;
});