<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Address extends Model
{
    use HasFactory, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
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
