<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = 'user';
    protected $fillable=[
        'first_name',
        'last_name',
        'password',
        'age',
        'email',
        'avatar',
        'gender',
    ];
}
