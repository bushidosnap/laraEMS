<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Profile extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'gender',
        'civil_status',
        'address',
        'contact',
        'bio',
        'skills',
        'date_of_birth',
        'image'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
