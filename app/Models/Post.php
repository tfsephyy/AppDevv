<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content',
        'images',
        'archived',
    ];

    protected $casts = [
        'images' => 'array',
        'archived' => 'boolean',
    ];

    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class)->whereNull('parent_id');
    }

    public function allComments()
    {
        return $this->hasMany(PostComment::class);
    }
}
