<?php
namespace App\Http\Resources;

use App\Models\Question;
use App\Models\Subcategory;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoriesResourceWeb extends JsonResource
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
            "category_name"=> $this->ar_name,
            "category_name_en"=> $this->en_name,
            "type"=>$this->type ,
            "row_order"=>$this->order ,
            "image"=> asset('storage/uploads/' . $this->image) ?? '',

        ];
    }
}
