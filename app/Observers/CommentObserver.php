<?php

namespace App\Observers;

use App\Models\Comment;
use App\Models\CommentHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CommentObserver
{
    /**
     * Handle the Comment "creating" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function creating(Comment $comment)
    {
        $comment->id = Str::uuid();

        if (Auth::check()) {
            $comment->user_id = Auth::user()->id;
        }
    }

    /**
     * Handle the Comment "created" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function created(Comment $comment)
    {
        //
    }

    /**
     * Handle the Comment "updated" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function updated(Comment $comment)
    {
        $oldValue = $comment->getOriginal('comment');

        CommentHistory::create([
            'id'         => Str::uuid(),
            'comment_id' => $comment->id,
            'old_value'  => $oldValue,
            'new_value'  => $comment->comment,
            'created_at' => now()
        ]);
    }

    /**
     * Handle the Comment "deleted" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function deleted(Comment $comment)
    {
        //
    }

    /**
     * Handle the Comment "restored" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function restored(Comment $comment)
    {
        //
    }

    /**
     * Handle the Comment "force deleted" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function forceDeleted(Comment $comment)
    {
        //
    }
}
