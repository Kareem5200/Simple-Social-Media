<?php
namespace App\Http\Repositories;

use App\Models\User;
use CRUDInterface;

class UserRepository{

    public function getById(int $id){
        return User::findOrFail($id);
    }

    public function create(array $data){
        return User::create($data);
    }

    public function update(array $data){
        return auth()->user()->update($data);
    }











}
