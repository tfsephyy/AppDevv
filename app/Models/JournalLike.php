<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalLike extends Model
{
    protected $fillable = [
        'journal_id',
        'user_id',
    ];

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }
}
