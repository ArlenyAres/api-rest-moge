<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Registration;
use App\Models\Category;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'location',
        'date',
        'category_id',
        'user_id'
    ];

    protected $dates = [
        'created_at',
        'delete_at',
];

public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function isUpcoming()
    {
        return $this->date > date('Y-m-d H:i:s');
    }
}
