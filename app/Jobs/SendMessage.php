<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;
use Illuminate\Support\Facades\Log;
use App\Events\GotMessage;

class SendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @param Message $message
     */
    public function __construct(public Message $message)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        try {
            GotMessage::dispatch([
                'id' => $this->message->id,
                'user_id' => $this->message->user_id,
                'room_id' => $this->message->room_id,
                'text' => $this->message->text,
                'time' => $this->message->created_at,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to process SendMessage job: ' . $e->getMessage());
        }
    }
}
