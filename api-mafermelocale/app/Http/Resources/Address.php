<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @OA\Schema(
 * schema="AddressResource",
 * type="object",
 * )

 */
class Address extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     * 
     * @OA\Property(type="integer", format="integer", description="id", property="id"),
     * @OA\Property(type="string", format="string", description="address", property="address"),
     * @OA\Property(type="string", format="string", description="postcode", property="postcode"),
     * @OA\Property(type="string", format="string", description="city", property="city"),
     * @OA\Property(type="float", format="float", description="longitude of the address", property="lon"),
     * @OA\Property(type="float", format="float", description="latitude of the address", property="lat"),
     * @OA\Property(type="integer", format="integer", description="country_id", property="country_id"),
     * @OA\Property(type="string", format="string", description="created_at", property="created_at"),
     * @OA\Property(type="string", format="string", description="updated_at", property="updated_at"),
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'address' => $this->address,
            'postcode' => $this->postcode,
            'city' => $this->city,
            'lon' => $this->lon,
            'lat' => $this->lat,
            'country_id' => $this->country_id,
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
        ];
    }
}
