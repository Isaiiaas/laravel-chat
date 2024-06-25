<?php

use Illuminate\Support\Facades\Broadcast;

// In an enviroment I need to scale I'd dinamically create a every single channel instead of handling all at once 
Broadcast::channel('room.{roomId}', function ($user, $roomId) {
    // Won't need an authorization or any kind of check for now
    return true; 
});