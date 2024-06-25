<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use App\Models\Room;

class DashboardController extends Controller
{
    
    /**
     * Display the dashboard view with all rooms.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function dashboardView(): View
    {
        $rooms = Room::paginate(100);
        return view('dashboard', ["rooms" => $rooms]);
    }
}

