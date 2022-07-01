<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

/**
 * @OA\Schema(
 * schema="Currency",
 * type="object",
 * )
 */
class Currency extends Model
{
    use HasFactory, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    /**
     * @OA\Property(type="string", format="string", description="The name of the currency", property="name"),
     * @OA\Property(type="string", format="string", description="The iso code of the currency", property="iso_code"),
     */
    protected $fillable = [
        'name',
        'iso_code'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function countries()
    {
        return $this->hasMany(Country::class);
    }

}
