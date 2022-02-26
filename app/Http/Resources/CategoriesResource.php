<?php
namespace App\Http\Resources;

use App\Models\Question;
use App\Models\Subcategory;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoriesResource extends JsonResource
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
            "language_id"=>$this->language_id ,
            "category_name"=> $this->ar_name,
            "category_name_en"=> $this->en_name,
            "type"=>$this->type ,
            "row_order"=>$this->order ,
            "image"=> $this->image ? env('APP_URL'). $this->image :env('APP_URL').'storage/default_category.jpg' ,
            "no_of"=>Subcategory::where('category_id',$this->id)->count(),
            'no_of_que' =>Question::where('category_id',$this->id)->count(),
            "maxlevel"=> \DB::table('questions')->where('category_id',$this->id)->max('level_id'),
        ];
    }
}
