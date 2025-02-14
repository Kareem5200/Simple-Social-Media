<?php
namespace App\Http\Services;

use Exception;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\Verification\SendVerificationNotification;


class VerificationService{

    public function sendVerificationNotification($user,$notification_service){
        $this->checkIfVerified($user);
        $notification_service->sendNotificationToUser($user,new SendVerificationNotification());
    }

    public function verify($user,$user_id,$hash){
        $this->checkIfVerified($user);

        if($user->getKey() != $user_id){
            throw new exception('error in user id');
        }

        if(sha1($user->getEmailForVerification()) != $hash){
            throw new exception('error in hashed value');
        }

        return $user->markEmailAsVerified();

    }

    public function checkIfVerified($user){

        if($user->hasVerifiedEmail()){
            throw new Exception('Already verified');
        }
    }



}
