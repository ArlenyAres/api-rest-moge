<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Registration;
use App\Models\Category;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    const CATEGORY_PRESENCIAL = 1;
    const CATEGORY_ONLINE = 2;
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


    protected $hidden = [
        'updated_at',
        'created_at',
        'delete_at',
    ];

public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    
    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function isUpcoming()
    {
        return $this->date > date('Y-m-d H:i:s');
    }

    public function registeredUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'registrations')->withTimestamps();
    }
}
