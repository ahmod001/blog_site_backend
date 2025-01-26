<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;


    protected static function boot(): void
    {
        static::saving(function ($post) {
            $post->slug = Str::slug($post->title);
        });
    }
}
