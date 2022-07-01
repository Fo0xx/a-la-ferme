<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

/**
 * @OA\Schema(
 * schema="Farm",
 * type="object",
 * )
 */
class Farm extends Model
{
    use HasFactory, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    /**
     * @OA\Property(type="string", format="string", description="The name of the farm", property="name"),
     * @OA\Property(type="string", format="string", description="The link to the image of the farm", property="farm_image"),
     * @OA\Property(type="string", format="string", description="The short description of the farm", property="short_description"),
     * @OA\Property(type="integer", format="int", description="The id of the address", property="address_id"),
     * @OA\Property(type="integer", format="int", description="The id of the farm details", property="farm_details_id"),
     * @OA\Property(type="integer", format="int", description="The id of the user", property="user_id"),
     * @OA\Property(type="integer", format="int", description="The id of the lang", property="lang_id"),
     */
    protected $fillable = [
        'name',
        'farm_image',
        'short_description',
        'address_id',
        'farm_details_id',
        'user_id',
        'lang_id'
    ];

    public function lang()
    {
        return $this->belongsTo(Lang::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function farm_detail()
    {
        return $this->hasOne(Farm_details::class, 'id', 'farm_details_id');
    }

    public function address()
    {
        return $this->hasOne(Address::class, 'id', 'address_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
