<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

/**
 * @OA\Schema(
 * schema="Product",
 * type="object",
 * )
 */
class Product extends Model
{
    use HasFactory, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    /**
     * @OA\Property(type="string", format="string", description="The name of the product", property="product_name"),
     * @OA\Property(type="integer", format="int", description="The price of the product", property="price"),
     * @OA\Property(type="string", format="string", description="The link to the image of the product", property="product_image"),
     * @OA\Property(type="string", format="string", description="The short description of the product", property="short_description"),
     * @OA\Property(type="integer", format="int", description="The id of the category", property="category_id"),
     * @OA\Property(type="integer", format="int", description="The id of the farm", property="farm_id"),
     * @OA\Property(type="integer", format="int", description="The id of the lang", property="lang_id"),
     */
    protected $fillable = [
        'product_name',
        'price',
        'product_image',
        'category_id',
        'farm_id',
        'lang_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }

    public function lang()
    {
        return $this->belongsTo(Lang::class);
    }
}
