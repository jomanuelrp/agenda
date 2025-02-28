<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'organization',
        'position',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }
}
