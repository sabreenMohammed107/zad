<?php
namespace App\Http\Resources;

use App\Models\Question;
use App\Models\Subcategory;
use Illuminate\Http\Resources\Json\JsonResource;

class SubcategoryResourceWeb extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            "id"=>$this->id,
            "language" =>  $this->language,
            "category" => $this->category,
            "ar_name"=> $this->ar_name,
            "en_name"=> $this->en_name,
            "row_order"=>$this->order ,
            "status"=>$this->status,
            "image"=> asset('storage/uploads/' . $this->image) ?? '',

        ];
    }
}
