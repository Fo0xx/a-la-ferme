<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

/**
 * @OA\Schema(
 *  schema="Address",
 * type="object",
 * )
 */
class Address extends Model
{
    use HasFactory, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    /**
     * @OA\Property(type="string", format="string", description="address", property="address"),
     * @OA\Property(type="string", format="string", description="postcode", property="postcode"),
     * @OA\Property(type="string", format="string", description="city", property="city"),
     * @OA\Property(type="float", format="float", description="longitude of the address", property="lon"),
     * @OA\Property(type="float", format="float", description="latitude of the address", property="lat"),
     */
    protected $fillable = [
        'address',
        'postcode',
        'city',
        'lon',
        'lat',
        'country_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'address_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }

    
}
