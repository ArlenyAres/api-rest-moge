<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
];

    protected $hidden = [
        'updated_at',
        'created_at',
        'delete_at',
    ];


    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
