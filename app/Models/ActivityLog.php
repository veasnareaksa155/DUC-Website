<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_name',
        'action',
        'module',
        'icon_class',
    ];

    /**
     * Helper to log an administrative activity.
     */
    public static function log(string $action, string $module = 'system', ?string $iconClass = null): self
    {
        if (!$iconClass) {
            $iconClass = match($module) {
                'events' => 'bg-amber-500/10 text-amber-500',
                'navigation' => 'bg-blue-500/10 text-blue-500',
                'pages' => 'bg-indigo-500/10 text-indigo-500',
                'faculties', 'departments' => 'bg-emerald-500/10 text-emerald-500',
                'translations' => 'bg-purple-500/10 text-purple-500',
                'settings', 'home' => 'bg-rose-500/10 text-rose-500',
                default => 'bg-slate-500/10 text-slate-500'
            };
        }

        $userName = Auth::check() ? (Auth::user()->name ?: Auth::user()->email) : 'Admin';

        return self::create([
            'user_name' => $userName,
            'action' => $action,
            'module' => $module,
            'icon_class' => $iconClass,
        ]);
    }
}
