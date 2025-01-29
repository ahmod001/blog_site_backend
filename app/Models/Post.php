<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $guarded = ['slug'];


    protected static function boot(): void
    {
        parent::boot(); 
        
        static::saving(function ($post) {
            $post->slug = create_slug($post, $post->title);
        });
    }
}
