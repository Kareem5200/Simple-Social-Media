<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Post;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckExistsingPostID
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {


        if($id = (int)$request->route('id')){

            if(!Post::withTrashed()->where('id',$id)->exists()){
                return response()->json([
                    'status'=>false,
                    'message'=>'Undefined post',
                ],404);
            }
        }



        return $next($request);
    }
}
