<?php

namespace App\Http\Controllers;

use App\Models\SLog;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $logs = SLog::get();
        $users = User::get();

        return view('dashboard.index',  compact('logs'));
    }
}
