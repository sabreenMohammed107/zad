<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegisterResource extends JsonResource
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
            "name"=>$this->name ,
            "firebase_id"=> $this->firebase_id,
            "email"=>$this->email ,
            "mobile"=>$this->mobile ,
            "profile"=> $this->profile ? env('APP_URL'). $this->profile :env('APP_URL').'storage/default_profile.jpg' ,
            "type"=>$this->type,
            'token' =>$this->createToken('user')->accessToken,
            "fcm_id"=>$this->fcm_id ,
            "coins"=> $this->coins,
            "refer_code"=>$this->refer_code ,
            "friends_code"=>$this->friends_code ,
            "status"=> $this->status,
            "date_registered"=>$this->created_at,
        ];
    }
}
