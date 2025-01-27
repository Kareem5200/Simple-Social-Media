<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\CreateCommentRequest;
use App\Http\Services\CommentService;
use Exception;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct(public CommentService $comment_service)
    {

    }


    //need notification for the post owner
    public function create(CreateCommentRequest $request , $commentable_type , $commentable_id){
        try{
            $this->comment_service->create($request->validated(),$commentable_type,$commentable_id);
            return $this->returnSuccessMessage('Comment created successfully');
        }catch(Exception $exception){
            return $this->returnErrorMessage($exception->getMessage());
        }
    }

    public function get($id){
        try{
            $comment = $this->comment_service->getWithLikes($id);
            return $this->returnData('Comment returned succesfully',$comment);
        }catch(Exception $exception){
            return $this->returnErrorMessage($exception->getMessage());
        }
    }

    public function update(CreateCommentRequest $request,$id){

        try{

            $comment = $this->comment_service->get($id);
            $this->authorize('forceDelete',$comment);
            $this->comment_service->update($comment,$request->validated());
            return $this->returnSuccessMessage('Comment updated successfully');

        }catch(Exception $exception){
            return $this->returnErrorMessage($exception->getMessage());
        }

    }

    
    public function delete($id){
        try{

            $comment = $this->comment_service->get($id);
            $this->authorize('forceDelete',$comment);
            $this->comment_service->delete($comment);
            return $this->returnSuccessMessage('Comment deleted successfully');


        }catch(Exception $exception){
            return $this->returnErrorMessage($exception->getMessage());


        }

    }




}
