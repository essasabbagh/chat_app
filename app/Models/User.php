<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'profile_picture',
        'bio',
        'phone_number',
        'last_login_at',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relationship: Messages sent by this user
     */
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Relationship: Messages received by this user
     */
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /**
     * Scope to search users
     */
    public function scopeSearch($query, $term)
    {
        return $query->where('name', 'LIKE', "%{$term}%")
                     ->orWhere('email', 'LIKE', "%{$term}%")
                     ->orWhere('username', 'LIKE', "%{$term}%");
    }

    /**
     * Get the user's full profile
     */
    public function getProfileAttribute()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'profile_picture' => $this->profile_picture
                ? url('storage/' . $this->profile_picture)
                : null,
            'bio' => $this->bio,
            'last_login' => $this->last_login_at
        ];
    }

    /**
     * Check if user is online
     */
    public function isOnline()
    {
        return $this->status === 'online';
    }

    /**
     * Update last login timestamp
     */
    public function updateLastLogin()
    {
        $this->last_login_at = now();
        $this->save();
    }

    /**
     * Generate a unique username
     */
    public static function generateUniqueUsername($name)
    {
        $username = strtolower(str_replace(' ', '_', $name));
        $originalUsername = $username;
        $i = 1;

        while (self::where('username', $username)->exists()) {
            $username = $originalUsername . '_' . $i;
            $i++;
        }

        return $username;
    }
}
