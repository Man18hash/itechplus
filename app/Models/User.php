<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use App\Models\CartItem;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Mass‐assignable attributes.
     */
    protected $fillable = [
        'first_name', 'last_name',
        'company_name', 'company_size', 'position',
        'street', 'barangay', 'city', 'region',
        'mobile', 'email', 'password',
        'profile_image',
    ];

    /**
     * Hidden for arrays / JSON.
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Accessors to append to the model’s array/JSON form.
     */
    protected $appends = [
        'profile_image_url',
    ];

    /**
     * Auto‐hash password on assignment.
     */
    public function setPasswordAttribute($value)
    {
        // only hash if not already hashed
        if ($value && \Illuminate\Support\Str::startsWith($value, '$2y$') === false) {
            $value = bcrypt($value);
        }
        $this->attributes['password'] = $value;
    }

    /**
     * Get a full URL to the user’s profile image
     * (or a default placeholder if none uploaded).
     */
    public function getProfileImageUrlAttribute(): string
    {
        if ($this->profile_image && Storage::disk('public')->exists($this->profile_image)) {
            return asset('storage/' . $this->profile_image);
        }

        // fallback avatar
        return asset('images/default-profile.png');
    }

    /**
     * One‐to‐many to cart items.
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
