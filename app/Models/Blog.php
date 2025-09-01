<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Blog extends Model
{
    use Sluggable, HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'category',
        'slug',
    ];
    public function sluggable(): array{

        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

}
