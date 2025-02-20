<?php

namespace App\Http\Controllers;

use App\Models\AccessStatistic;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $statistics = AccessStatistic::getStatistics();
        
        return view('dashboard.index', [
            'todayVisits' => $statistics['today_visits'],
            'totalVisits' => $statistics['total_visits']
        ]);
    }
}