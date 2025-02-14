<?php

namespace App\Http\Controllers\Auth;

use Exception;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Http\Services\NotificationService;
use App\Http\Services\VerificationService;

class VerificationController extends Controller
{
    public function __construct(public VerificationService $verification_service){

    }
    public function sentVerificationNotification(Request $request,NotificationService $notification_sevice){


        try{

            $this->verification_service->sendVerificationNotification($request->user(),$notification_sevice);
            return $this->returnSuccessMessage('Check your account for verification mail');

        }catch(Exception $exception){

            return $this->returnErrorMessage($exception->getMessage());

        }



    }

    public function verify(Request $request,$id,$hash){

        try{
            $this->verification_service->verify($request->user() ,$id ,$hash);
            return $this->returnSuccessMessage('Your email is verified');
        }catch(Exception $exception){

            return $this->returnErrorMessage($exception->getMessage());
        }

    }




}
