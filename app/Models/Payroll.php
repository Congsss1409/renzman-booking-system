<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payroll extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'therapist_id',
        'period_start',
        'period_end',
        'gross',
        'therapist_share',
        'owner_share',
        'deductions',
        'net',
        'status',
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end' => 'date',
        'gross' => 'decimal:2',
        'therapist_share' => 'decimal:2',
        'owner_share' => 'decimal:2',
        'deductions' => 'decimal:2',
        'net' => 'decimal:2',
    ];

    public function therapist()
    {
        return $this->belongsTo(Therapist::class);
    }

    public function items()
    {
        return $this->hasMany(PayrollItem::class);
    }

    public function payments()
    {
        return $this->hasMany(PayrollPayment::class);
    }
}
