<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
/**
 * @OA\Schema(
 * schema="Category",
 * type="object",
 * )
 */
class Category extends Model
{
    use HasApiTokens, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    /**
     * @OA\Property(type="string", format="string", description="The name of the category", property="name"),
     * @OA\Property(type="string", format="string", description="The description of the category", property="description"),
     * @OA\Property(type="string", format="string", description="The link to the image of the category", property="image_path"),
     * @OA\Property(type="string", format="string", description="The id of the lang", property="lang_id"),
     */
    protected $fillable = [
        'name',
        'description',
        'image_path',
        'lang_id'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function lang()
    {
        return $this->belongsTo(Lang::class);
    }

}
