<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
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
            'data' => $this->collection->transform(function ($data) {
                return [
                    'id' => $data->id,
                    'category_id' => $data->category_id,
                    'name' => $data->name,
                    'description' => $data->description,
                    'image' => $data->image,
                    'waiting_time' => $data->waiting_time,
                    'price' => $data->price,
                    'view_count' => $data->view_count,
                    'created_at' => $data->created_at->format('d m Y'),
                    'updated_at' => $data->updated_at->format('d m Y'),
                    'category' => Category::where('id', $data->category_id)->select('id', 'name')->first(),
                ];
            })
        ];
    }
}
