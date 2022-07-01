<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
/**
 * @OA\Schema(
 * schema="Country",
 * type="object",
 * )
 */
class Country extends Model
{
    use HasFactory, HasApiTokens;

    /**
     * @OA\Property(type="string", format="string", description="The name of the country", property="name"),
     * @OA\Property(type="string", format="string", description="The iso code of the country", property="iso_code"),
     * @OA\Property(type="integer", format="int", description="The id of the currency", property="currency_id"),
     */
    protected $fillable = [
        'name',
        'iso_code',
        'currency_id'
    ];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
