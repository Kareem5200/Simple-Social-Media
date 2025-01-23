<?php
namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Auth\User as Authenticatable;


trait ResponseStructureTrait{

    private function mainStructure(bool $status,string $message,array|object $data=[],?string $token=null,?object $user=null,int $status_code=200,array $headers=[]){

        $reponse=[
        'status'=>$status,
        'message'=>$message,
       ];

       empty($data)?:$reponse['data']=$data;
       empty($token)?:$reponse['token']=$token;
       empty($user)?:$reponse['user']=$user;


       return response()->json($reponse,$status_code,$headers);
    }


    public function returnSuccessMessage(string $message,int $status_code=200,array $headers=[]){

        return $this->mainStructure(true,$message,[],null,null,$status_code,$headers);
    }

    public function returnErrorMessage(string $message,int $status_code=400,array $headers=[]){

        return $this->mainStructure(false,$message,[],null,null,$status_code,$headers);

    }

    public function returnData(string $message,$data,int $status_code=200,array $headers=[]){

        return $this->mainStructure(true,$message,$data,null,null,$status_code,$headers);

    }

    public function returnToken(string $message,string $token,?object $user=null,int $status_code=200,array $headers=[]){

        return $this->mainStructure(true,$message,[],$token,$user,$status_code,$headers);

    }
}
