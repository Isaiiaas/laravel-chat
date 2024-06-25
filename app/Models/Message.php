<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    public $table = 'messages';
    protected $fillable = ['id', 'user_id', 'room_id', 'text'];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function room(): BelongsTo {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function getFormattedTimeAttribute(): string {
        return date(
            "d M Y, H:i:s",
            strtotime($this->attributes['created_at'])
        );
    }
}