<?php

namespace App\Models;

use App\Models\Scopes\PostScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Post extends Model
{
    use HasFactory;
    protected $guarded = ['slug'];

    protected $hidden = [
        'updated_at'
    ];

    protected $appends = ['published_at'];

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function ($post) {
            $post->slug = create_slug($post, $post->title);
        });

        static::addGlobalScope(new PostScope);
    }



    public function scopePagination($query, $limit = 10)
    {
        return $query->paginate($limit);
    }


    public function getPublishedAtAttribute(): string
    {
        $formattedDate = Carbon::parse($this->attributes['created_at'])->diffForHumans();
        return $formattedDate;
    }

    public function getCreatedAtAttribute($value): string
    {
        $formattedDate = date('d M, Y', strtotime($value));
        return $formattedDate;
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }



    /**
     * Check if the post is authorized by the user to perform mutations
     * 
     */
    public function is_authorized(int $user_id): bool
    {
        return $this->attributes['author_id'] === $user_id;
    }
}
