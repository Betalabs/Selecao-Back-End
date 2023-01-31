<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AllCommentResource;
use App\Http\Services\CommentServices;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AllCommentController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::orderBy('created_at', 'ASC')->get();

        return response()->json([
            'success' => true,
            'comment' => AllCommentResource::collection($comments),
            'message' => 'All Comments In Successfully!',
        ], Response::HTTP_OK);
    }

    public function destroy(CommentServices $commentServices)
    {
        if (!Auth::user()->admin) {
            return response()->json([
                'success' => false,
                'comment' => [],
                'message' => 'You do not have permission to delete all comments!',
            ], Response::HTTP_OK);
        }

        try {
            $commentServices->deleteAll();

            return response()->json([
                'success' => true,
                'comment' => [],
                'message' => 'All Comments Deleted Successfully!',
            ], Response::HTTP_OK);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message'   => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
