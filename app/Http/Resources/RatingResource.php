<?php

namespace App\Http\Resources;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'product_id' => $this->product_id,
            'rating_count' => $this->rating_count,
            'created_at' => $this->created_at->format('d m Y'),
            'updated_at' => $this->updated_at->format('d m Y'),
            'user' => User::where('id', $this->user_id)->select('id', 'name')->first(),
            'product' => Product::where('id', $this->product_id)->select('id', 'name')->first(),
        ];
    }
}
