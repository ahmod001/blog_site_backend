<?php

namespace App\Models;

use App\Observers\CategoryObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


#[ObservedBy([CategoryObserver::class])]
class Category extends Model
{
    use HasFactory;

    protected $guarded = ['slug'];

    protected $hidden = ['updated_at', 'created_at'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }


    protected static function Title(): Attribute
    {

        return Attribute::make(
            set: fn($value) => strtolower($value),
            get: fn($value) => ucfirst($value)
        );
    }
}
