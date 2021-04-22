<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Payroll extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'payroll_name',
        'employment_id',
        'rate',
        'hours_worked',
        'overtime',
        'benefit_deduction',
        'other_deduction',
    ];

    public function employment(){
        return $this->belongsTo(Employment::class, 'employment_id')->where('status', 1);
    }
}
