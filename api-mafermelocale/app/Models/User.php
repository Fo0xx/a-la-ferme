<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @OA\Schema(
 * schema="User",
 * type="object",
 * )
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     * 
     * @OA\Property(type="string", format="string", description="The name of the user", property="first_name"),
     * @OA\Property(type="string", format="string", description="The last name of the user", property="last_name"),
     * @OA\Property(type="string", format="string", description="The email of the user", property="email"),
     * @OA\Property(type="string", format="string", description="The password of the user", property="password"),
     * @OA\Property(type="integer", format="int", description="The id of the role", property="role_id"),
     * @OA\Property(type="integer", format="int", description="The id of the address", property="address_id"),
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role_id',
        'address_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     * 
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
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class, 'id', 'address_id');
    }

    public function votes() {
        return $this->hasMany(Vote::class);
    }

    public function farm() {
        return $this->hasOne(Vote::class);
    }
}
