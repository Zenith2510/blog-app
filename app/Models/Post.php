<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $fillable = [
        'title',
        'content',
        'user_id',
        'tag_id',
    ];

    public function scopeSearch($query, $value)
    {
        $query->where('title', 'like', "&{$value}&");
    }
    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
