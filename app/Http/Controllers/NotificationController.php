<?php

namespace App\Http\Controllers;

use App\Http\Services\NotificationService;
use Exception;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(public NotificationService $notification_service)
    {

    }
    public function get(){

        try{
            if($notifications = $this->notification_service->get()){
                return $this->returnData('Notification returned successfully',$notifications);
            }
            return $this->returnSuccessMessage('Has no notifications');

        }catch(Exception $exception){
            return $this->returnErrorMessage($exception->getMessage());
        }

    }

    public function delete($id){
        try{
            $this->notification_service->delete($id);
            return $this->returnSuccessMessage('Notification deleted successfully');

        }catch(Exception $exception){
            return $this->returnErrorMessage($exception->getMessage());
        }


    }

}
