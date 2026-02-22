<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Chat extends Model
{
    protected $fillable = ['user_id', 'message', 'reported', 'is_admin'];
    
    protected $casts = [
        'reported' => 'boolean',
        'is_admin' => 'boolean'
    ];
    
    public function userAccount()
    {
        return $this->belongsTo(UserAccount::class, 'user_id', 'id');
    }
    
    public function getDisplayNameAttribute()
    {
        if ($this->is_admin) {
            return 'ADMIN';
        }
        return $this->userAccount ? $this->userAccount->name : $this->user_id;
    }
}
