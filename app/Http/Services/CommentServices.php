<?php

namespace App\Http\Services;

use App\Models\Comment;
use Illuminate\Support\Str;

class CommentServices
{
    public function create(array $request)
    {
        $comment = Comment::create([
            'comment' => $request['comment']
        ]);

        $comment->refresh();

        return $comment;
    }

    public function delete(Comment $comment)
    {
        return Comment::destroy($comment->id);
    }

    public function deleteAll()
    {
        $ids = Comment::all()->pluck('id')->toArray();

        return Comment::destroy($ids);
    }

    public function getAllByUser(string $id)
    {
        return Comment::where('user_id', $id)->get();
    }

    public function update(Comment $comment, array $validated)
    {
        $comment->update($validated);

        return $comment;
    }
}
