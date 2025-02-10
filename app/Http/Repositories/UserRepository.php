<?php
namespace App\Http\Repositories;

use App\Models\Post;
use App\Models\User;
use App\Models\SharedPost;
use Illuminate\Support\Facades\DB;

class UserRepository{

    public function getById(int $id,array $select){
        return User::select($select)->findOrFail($id);
    }

    public function create(array $data){
        return User::create($data);
    }

    public function update(array $data){
        return auth()->user()->update($data);
    }













}
