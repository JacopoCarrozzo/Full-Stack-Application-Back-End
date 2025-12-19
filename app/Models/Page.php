<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'is_published',
        'published_at',
    ];

    protected $casts = [
    'content' => 'array', 
    'is_published' => 'boolean', 
    'published_at' => 'datetime',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
];

    public function menuLinks(): HasMany
    {
        return $this->hasMany(MenuLink::class);
    }
}