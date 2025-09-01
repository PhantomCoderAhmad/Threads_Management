<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'blog_id',
        'blog_comment',
        'username',
    ];

    
    public function blog(){
        return $this->belongsTo(Blog::class);
    }

    public function replies(){
        return $this->hasMany(Reply::class);
    }
}
