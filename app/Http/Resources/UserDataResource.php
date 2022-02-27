<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserDataResource extends JsonResource
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
            "firebase_id"=> $this->firebase_id,
            "name"=>$this->name ,
            "email"=>$this->email ,
            "mobile"=>$this->mobile ,
            "type"=>$this->type,
            "profile"=> $this->profile ? env('APP_URL'). $this->profile :env('APP_URL').'storage/default_profile.jpg' ,
            "fcm_id"=>$this->fcm_id ,
            "coins"=> $this->coins,
            "refer_code"=>$this->refer_code ,
            "friends_code"=>$this->friends_code ,
            "status"=> $this->status,
            "date_registered"=>$this->created_at,
            "all_time_score"=> "34",
            "all_time_rank"=> "2",
        ];
    }
}
