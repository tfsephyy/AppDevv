<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounselingSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_account_id',
        'status',
        'diagnosis',
        'last_session',
        'note',
        'archived',
    ];

    protected $casts = [
        'last_session' => 'date',
    ];

    public function userAccount()
    {
        return $this->belongsTo(UserAccount::class);
    }
}
