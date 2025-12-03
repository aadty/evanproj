<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\user;

class DashboardController extends Controller
{
    /**
     * Show the dashboard (protected route)
     */
    public function index()
    {
        $user = auth()->user();
        return view('dashboard', ['user' => $user]);
    }
}
