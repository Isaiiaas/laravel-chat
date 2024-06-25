<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use App\Models\Room;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RoomController extends Controller
{
    /**
     * Display the room view.
     *
     * @param  int  $roomId
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function roomView(int $roomId): View|RedirectResponse
    {
        try {
            $roomInfo = Room::findOrFail($roomId);
            return view('room', ['roomName' => $roomInfo->name, 'roomId' => (int) $roomId]);
        } catch (ModelNotFoundException $e) {            
            return redirect()->route('dashboard')->with('error', 'Room not found.');
        }
    }
}
