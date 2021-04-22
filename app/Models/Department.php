<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;


class Department extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'dept_name',
    ];

    public function employment(){
        return $this->hasOne(Employment::class);
    }
}
