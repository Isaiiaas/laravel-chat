<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Message;
use App\Jobs\SendMessage;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    /**
     * Retrieve messages for a given room.
     *
     * @param  int  $roomId
     * @return \Illuminate\Http\JsonResponse
     */
    public function messageGet(Int $roomId): JsonResponse 
    {
        $messages = Message::where('room_id', $roomId)
                            ->orderBy('id', 'asc')
                            ->with('user')
                            ->get()
                            ->append('time');

        return response()->json($messages);
    }

    /**
     * Send a new message to a room.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function messageSend(Request $request): JsonResponse 
    {        
        $validator = Validator::make($request->all(), [
            'room_id' => ['required', 'integer'],
            'text' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $message = Message::create([
            'user_id' => auth()->id(),
            'room_id' => $request->input('room_id'),
            'text' => $request->input('text'),
        ]);

        SendMessage::dispatch($message);

        return response()->json([
            'success' => true,
            'message' => "Message created and job dispatched.",
        ]);
    }
}
