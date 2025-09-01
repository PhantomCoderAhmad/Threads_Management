<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'blog_id',
        'comment_id',
        'comment_reply',
        'reply_user',
    ];

    public function comment(){
        return $this->belongsTo(Comment::class);
    }
}
