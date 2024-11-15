<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'description',
        'slug',
        'bg_color'
    ];

    #relations
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tag');
    }
    #end relations

    #setters
    protected function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
    #endsetters
}
