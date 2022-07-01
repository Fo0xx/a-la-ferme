<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

/**
 * @OA\Schema(
 * schema="Role",
 * type="object",
 * )
 */
class Role extends Model
{
    use HasApiTokens, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    /**
     * @OA\Property(type="string", format="string", description="The name of the role", property="name"),
     * @OA\Property(type="integer", format="int", description="The id of the lang", property="lang_id"),
     */
    protected $fillable = [
        'name',
        'lang_id'
    ];

    public function users() {
        return $this->hasMany(User::class);
    }

    public function lang() {
        return $this->belongsTo(Lang::class);
    }
}
