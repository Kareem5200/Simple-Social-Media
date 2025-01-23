<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Models\Post;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckExistsingPost
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $postId = $request->route('post'); // Retrieve the {post} parameter from the route

        // Check if the Post exists
        if (!Post::find($postId)) {
            return response()->json(['error' => 'Post not found'], 404);
        }
            return $next($request);

    }
}
