<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Message extends Model
{
    use HasFactory;

    public $table = 'messages';
    protected $fillable = [
        'id', 
        'user_id', 
        'room_id', 
        'text'
    ];

    public function user(): BelongsTo 
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function getTimeAttribute(): string
    {
        return Carbon::parse($this->created_at)->format('d M Y, H:i:s');
    }
}
