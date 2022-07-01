<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

/**
 * @OA\Schema(
 * schema="Lang",
 * type="object",
 * )
 */
class Lang extends Model
{
    use HasFactory, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    /**
     * @OA\Property(type="string", format="string", description="The name of the lang", property="name"),
     * @OA\Property(type="string", format="string", description="The iso code of the lang", property="iso_code"),
     * @OA\Property(type="string", format="string", description="The locale of the lang", property="language_locale"),
     * @OA\Property(type="string", format="string", description="The date format lite of the lang", property="date_format_lite", example="d/m/Y"),
     * @OA\Property(type="string", format="string", description="The date format full of the lang", property="date_format_full", example="d/m/Y H:i:s"),
     */
    protected $fillable = [
        'name',
        'iso_code',
        'langage_locale',
        'date_format_lite',
        'date_format_full'
    ];

    public function roles()
    {
        return $this->hasMany(Role::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function farms()
    {
        return $this->hasMany(Farm::class);
    }

    public function farm_details()
    {
        return $this->hasMany(Farm_details::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
