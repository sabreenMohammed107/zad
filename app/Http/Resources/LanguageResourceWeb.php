<?php
namespace App\Http\Resources;

use App\Models\Question;
use App\Models\Subcategory;
use Illuminate\Http\Resources\Json\JsonResource;

class LanguageResourceWeb extends JsonResource
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

            "ar_name"=> $this->ar_name,
            "en_name"=> $this->en_name,


        ];
    }
}
