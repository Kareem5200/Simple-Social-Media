<?php

namespace App\Http\Controllers;

use App\Http\Services\PostService;
use Exception;
use Illuminate\Http\Request;
use nApp\Http\Services\LikeService;

class LikeController extends Controller
{
    public function __construct(public LikeService $like_service)
    {

    }

    public function create(Request $request,PostService $post_service,$id){

        try{

            $this->like_service->create($post_service,$id);

        }catch(Exception $exception){

            $this->returnErrorMessage($exception->getMessage());
        }
    }

    public function delete(Request $request,$id){
        try{

        }catch(Exception $exception){
            
            $this->returnErrorMessage($exception->getMessage());

        }

    }
}
