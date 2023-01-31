<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AllCommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AllCommentController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $comments = Comment::orderBy('created_at', 'ASC')->get();

        return response()->json([
            'success' => true,
            'comment' => AllCommentResource::collection($comments),
            'message' => 'All Comments In Successfully!',
        ], Response::HTTP_OK);
    }
}
