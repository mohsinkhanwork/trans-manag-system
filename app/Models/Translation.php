<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    protected $fillable = [
        'key',
        'value',
        'locale',
        'tags'
    ];

    protected $casts = [
        'tags' => 'array'
    ];

    public function scopeByLocale($query, $locale)
    {
        return $query->where('locale', $locale);
    }

    public function scopeByKey($query, $key)
    {
        return $query->where('key', $key);
    }

    public function scopeByTag($query, $tag)
    {
        return $query->whereJsonContains('tags', $tag);
    }

    public function scopeSearchContent($query, $searchTerm)
    {
        return $query->where('value', 'like', "%{$searchTerm}%");
    }
}
