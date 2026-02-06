<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', 'nama', 'hubungan', 'tanggal_lahir', 'pekerjaan', 'alamat',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
