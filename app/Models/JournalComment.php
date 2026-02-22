<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalComment extends Model
{
    protected $fillable = [
        'journal_id',
        'user_id',
        'user_name',
        'comment',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }
}
