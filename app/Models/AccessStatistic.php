<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AccessStatistic extends Model
{
    protected $table = 'access_statistics';
    
    protected $fillable = [
        'date', 
        'today_visits'
    ];

    // Method to increment daily visits
    public static function incrementVisits()
    {
        $today = Carbon::today()->toDateString();
        
        // Create or get today's statistic
        $statistic = self::firstOrCreate(
            ['date' => $today],
            ['today_visits' => 0]
        );
        
        // Increment today's visits
        $statistic->increment('today_visits');
        
        return $statistic;
    }

    // Get statistics for today and total
    public static function getStatistics()
    {
        $today = Carbon::today()->toDateString();
        
        $todayStats = self::where('date', $today)->first() ?? 
            ['today_visits' => 0];
        
        $totalVisits = self::sum('today_visits');
        
        return [
            'today_visits' => $todayStats['today_visits'] ?? 0,
            'total_visits' => $totalVisits
        ];
    }
}