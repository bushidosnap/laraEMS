<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Position extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'position_name',
        'salary',
    ];

    public function employment(){
        return $this->hasOne(Employment::class);
    }
}
