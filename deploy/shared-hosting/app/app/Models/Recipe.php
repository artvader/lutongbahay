<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'external_id',
        'title',
        'slug',
        'description',
        'image_url',
        'image_alt',
        'prep_mins',
        'cook_mins',
        'difficulty',
        'rating',
        'rating_count',
        'region',
        'course',
        'main_ingredient',
        'featured',
        'ingredients',
        'steps',
        'excerpt',
        'content',
        'status',
        'author_id',
        'published_at',
    ];

    protected $casts = [
        'prep_mins' => 'integer',
        'cook_mins' => 'integer',
        'rating' => 'float',
        'rating_count' => 'integer',
        'featured' => 'boolean',
        'ingredients' => 'array',
        'steps' => 'array',
        'published_at' => 'datetime',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
