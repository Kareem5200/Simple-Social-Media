<?php
namespace App\Http\Repositories;

use App\Models\User;
use CRUDInterface;

class UserRepository{

    public function getById(int $id){
        return User::find($id);
    }

    public function create(array $data){
        return User::create($data);
    }

    public function update(array $data,object $object){
        return $object->update($data);
    }











}
