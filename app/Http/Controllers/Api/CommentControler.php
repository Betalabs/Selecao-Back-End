<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Http\Services\CommentServices;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CommentControler extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CommentServices $commentServices)
    {
        $comments = $commentServices->getAllByUser(Auth::user()->id);

        if (!$comments->all()) {
            return response()->json([
                'success' => true,
                'comment' => [],
                'message' => 'This user has no Comments',
            ], Response::HTTP_NO_CONTENT);
        }

        return response()->json([
            'success' => true,
            'comment' => CommentResource::collection($comments),
            'message' => 'All Comments for This User',
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommentRequest $request, CommentServices $commentServices)
    {
        try {
            $validated = $request->validated();

            $comment = $commentServices->create($validated);

            return response()->json([
                'success'   => true,
                'user'      => new CommentResource($comment),
                'message'   => 'Comment Created In Successfully!',
            ], Response::HTTP_CREATED);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message'   => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        return response()->json([
            'success'   => true,
            'user'      => new CommentResource($comment),
            'message'   => 'Get Comment Successfully!',
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCommentRequest  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCommentRequest $request, Comment $comment, CommentServices $commentServices)
    {
        try {
            $validated = $request->validated();

            if ($comment->user_id !== Auth::user()->id) {
                return response()->json([
                    'success' => false,
                    'comment' => [],
                    'message' => 'You do not have permission to edit this comment!',
                ], Response::HTTP_FORBIDDEN);
            }

            $data = $commentServices->update($comment, $validated);

            return response()->json([
                'success'   => true,
                'comment'      => new CommentResource($data),
                'message'   => 'Comment Updated In Successfully!',
            ], Response::HTTP_OK);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message'   => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment, CommentServices $commentServices)
    {
        try {
            if ($comment->user_id !== Auth::user()->id) {
                return response()->json([
                    'success' => false,
                    'comment' => [],
                    'message' => 'You do not have permission to delete this comment!',
                ], Response::HTTP_FORBIDDEN);
            }

            $commentServices->delete($comment);

            return response()->json([
                'success'   => true,
                'comment'   => [],
                'message'   => 'Comment Deleted In Successfully!',
            ], Response::HTTP_OK);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message'   => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
