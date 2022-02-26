<?php
namespace App\Http\Resources;

use App\Models\Question;
use App\Models\Subcategory;
use Illuminate\Http\Resources\Json\JsonResource;

class SubCategoriesResource extends JsonResource
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
            "maincat_id"=> $this->category_id,
            "subcategory_name"=> $this->en_name,
            "row_order"=>$this->order ,
            "image"=> $this->image ? env('APP_URL'). $this->image :env('APP_URL').'storage/default_category.jpg' ,
            'no_of_que' =>Question::where('sub_category_id',$this->id)->count(),
            "maxlevel"=> \DB::table('questions')->where('sub_category_id',$this->id)->max('level_id'),
        ];
    }
}
