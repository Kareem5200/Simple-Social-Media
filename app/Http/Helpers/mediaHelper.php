<?php

use Illuminate\Support\Facades\Storage;

if(!function_exists('uploadImage')){

    function uploadMedia($image,$path):string|bool{

        if(!Storage::exists($path)){
            return false;
        }


        $Extension = $image->getClientOriginalExtension();
        $image_name = time() . uniqid() . ".".$Extension;

        $image->storeAs($path,$image_name);
        return $image_name;
    }

}


if(!function_exists('checkUploadedFile')){
    function checkUploadedFile(array $data, string $image_name,$path){
        $uploaded_image = uploadMedia($data[$image_name],$path);
        if(!$uploaded_image){
            return false;
        }
        //  $new_path = ;
        // //  dd(asset($new_path));

        $data[$image_name]=$uploaded_image;
        return $data;
    }
}

