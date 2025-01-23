<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function sentVerificationNotification(Request $request){

       if($request->user()->hasVerifiedEmail()){
            return $this->returnErrorMessage('User already verified');
       }

       $request->user()->sendEmailVerificationNotification();

       return $this->returnSuccessMessage('Check you email for verification process');


    }

    public function verfiy(Request $request,$id,$hash){
        
        if(($id != $request->user()->getKey()) ||sha1($request->user()->getEmailForVerification() != $hash)){
            return $this->returnErrorMessage('Something wrong');
        }

        if($request->user()->hasVerifiedEmail()){
            return $this->returnErrorMessage('User already verified');
       }

       if($request->user()->markEmailAsVerified()){
        return $this->returnSuccessMessage('User Verified successfully');
       }

       return $this->returnErrorMessage('Something wrong');

    }


}
