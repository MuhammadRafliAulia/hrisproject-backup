<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id', 'user_name', 'action', 'module', 'description', 'ip_address', 'details',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Log an activity.
     *
     * @param string $action   e.g. 'create', 'update', 'delete', 'login', 'logout', 'export', 'import', 'sign'
     * @param string $module   e.g. 'auth', 'employee', 'department', 'warning_letter', 'bank_soal', 'question'
     * @param string $description  Human-readable description
     * @param string|null $details  Optional extra detail (JSON or text)
     */
    public static function log($action, $module, $description, $details = null)
    {
        $user = Auth::user();

        return static::create([
            'user_id' => $user ? $user->id : null,
            'user_name' => $user ? $user->name : 'System',
            'action' => $action,
            'module' => $module,
            'description' => $description,
            'ip_address' => Request::ip(),
            'details' => $details,
        ]);
    }
}
