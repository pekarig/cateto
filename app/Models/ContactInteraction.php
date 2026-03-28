<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactInteraction extends Model
{
    protected $fillable = [
        'action',
        'ip_address',
        'user_agent',
        'session_id',
        'referrer',
    ];

    /**
     * Statisztikák: összesített adatok
     */
    public static function getStatistics(): array
    {
        return [
            'total_checkbox_checks' => self::where('action', 'checkbox_checked')->count(),
            'total_accept_clicks' => self::where('action', 'accept_button_clicked')->count(),
            'unique_sessions' => self::distinct('session_id')->whereNotNull('session_id')->count(),
            'today_interactions' => self::whereDate('created_at', today())->count(),
            'this_week_interactions' => self::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'this_month_interactions' => self::whereMonth('created_at', now()->month)->count(),
        ];
    }
}
