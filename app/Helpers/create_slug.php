<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


if (!function_exists(('create_slug'))) {
    function create_slug(Model $model, string $string)
    {
        $separator = '-';
    
        $slug = Str::slug($string, $separator);

        $count = $model::where('slug', 'LIKE', "{$slug}%")->count();

        return $count ? "{$slug}{$separator}{$count}" : $slug;
    }
}
