<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    protected $table = 'user_accounts';

    protected $fillable = [
        'schoolId',
        'name',
        'email',
        'program',
        'year',
        'section',
        'password',
        'picture',
    ];

    protected $hidden = [
        'password',
    ];
}