<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Employment extends Model
{
    use HasFactory,HasApiTokens;

    protected $fillable = [
        'user_id',
        'dept_id',
        'pos_id',
        'emp_type',
        'contract_start',
        'contract_end',
        'status',
    ];

    public function department(){
        return $this->belongsTo(Department::class, 'dept_id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function position(){
        return $this->belongsTo(Position::class, 'pos_id');
    }

    public function payrolls(){
        return $this->hasMany(Payroll::class);
    }
}
