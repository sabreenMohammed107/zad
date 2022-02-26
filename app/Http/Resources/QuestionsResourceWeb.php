<?php
namespace App\Http\Resources;

use App\Models\Question;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionsResourceWeb extends JsonResource
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
            "id" => $this->id,
             "language" =>  $this->language,
            // "category" => CategoriesResourceWeb::make($this->category_id),
            "category" => $this->category,

            "sub_category" => $this->sub_category,
            "question" => $this->question,
            "image" => asset('storage/uploads/' . $this->image) ?? '',

            "category_name_en" => $this->en_name,
            "optiona" => $this->option_a,
            "optionb" => $this->option_b,
            "optionc" => $this->option_c,
            "optiond" => $this->option_d,
            "optione" => $this->option_e,
            "answer" => $this->answer,
            "level" => $this->level_id,
            "note" => $this->notes,

        ];
    }
}
