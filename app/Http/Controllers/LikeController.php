<?php

namespace App\Http\Controllers;

use Exception;

use Illuminate\Http\Request;
use App\Http\Services\PostService;
use App\Http\Services\LikeService;

class LikeController extends Controller
{


    public function __construct(public LikeService $like_service)
    {

    }

    public function create(Request $request,$likeable_type,$likeable_id){

        try{

            $this->like_service->create($likeable_type,$likeable_id);

            return $this->returnSuccessMessage('Like is done');
        }catch(Exception $exception){

            return $this->returnErrorMessage($exception->getMessage());
        }
    }

    public function delete(Request $request,$id){
        try{
            $like = $this->like_service->get($id);
            $this->authorize('forceDelete',$like);
            $this->like_service->delete($like);

            return $this->returnSuccessMessage('Unlike is done');

        }catch(Exception $exception){

           return  $this->returnErrorMessage($exception->getMessage());

        }

    }
}
