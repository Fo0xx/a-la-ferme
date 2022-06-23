<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class Farm_details extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'farm_banner' => $this->farm_banner,
            'about' => $this->about,
            'business_mail' => $this->buisness_mail,
            'phone' => $this->phone,
            'instagram_id' => $this->instagram_id,
            'facebook_id' => $this->facebook_id,
            'lang_id' => $this->lang_id,
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
        ];
    }
}
