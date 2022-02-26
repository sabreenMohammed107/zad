<?php
namespace App\Http\Resources;

use App\Models\Question;
use App\Models\Subcategory;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionsResource extends JsonResource
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
            "category"=> $this->category_id,
            "subcategory"=> $this->sub_category_id,
            "question_type"=>$this->question_type ,
            "question"=>$this->question ,
            "image"=> $this->image ? env('APP_URL'). $this->image :env('APP_URL').'storage/default_question.jpg' ,
            "optiona"=> $this->option_a,
            "optionb"=> $this->option_b,
            "optionc"=> $this->option_c,
            "optiond"=> $this->option_d,
            "optione"=> $this->option_e,
            "answer"=> $this->answer,
            "level"=> $this->level_id,
            "note"=> $this->notes
            
        ];
    }
}
