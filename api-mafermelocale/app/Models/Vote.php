<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

/**
 * @OA\Schema(
 * schema="Vote",
 * type="object",
 * )
 */
class Vote extends Model
{
    use HasFactory, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     * @OA\Property(type="integer", format="int", description="The amount of the vote", property="vote", minimum=0, maximum=5),
     * @OA\Property(type="integer", format="int", description="The id of the user", property="user_id"),
     * @OA\Property(type="integer", format="int", description="The id of the farm", property="farm_id"),
     */
    protected $fillable = [
        'vote',
        'farm_id',
        'user_id',
    ];

    public function farm() {
        return $this->belongsTo(Farm::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
