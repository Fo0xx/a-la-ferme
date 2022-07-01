<?php

namespace App\Models;

use Database\Factories\FarmDetailsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

/**
 * @OA\Schema(
 * schema="Farm_details",
 * type="object",
 * )
 */
class Farm_details extends Model
{
    use HasFactory, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    /**
     * @OA\Property(type="string", format="string", description="A link to the farm banner", property="farm_banner"),
     * @OA\Property(type="string", format="string", description="A description about the farm", property="about"),
     * @OA\Property(type="string", format="string", description="The email from the farm", property="business_mail"),
     * @OA\Property(type="string", format="string", description="The phone number from the farm", property="phone"),
     * @OA\Property(type="string", format="string", description="The instagram id from the farm", property="instagram_id"),
     * @OA\Property(type="string", format="string", description="The facebook id from the farm", property="facebook_id"),
     * @OA\Property(type="string", format="string", description="The lang id from the farm", property="lang_id"),
     */
    protected $fillable = [
        'about',
        'farm_banner',
        'business_mail',
        'phone',
        'instagram_id',
        'facebook_id',
        'lang_id'
    ];

    public function lang()
    {
        return $this->belongsTo(Lang::class);
    }

    public function farm()
    {
        return $this->belongsTo(Farm::class, null, 'farm_details_id');
    }
}
