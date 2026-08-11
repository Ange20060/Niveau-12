<?php

namespace App\Services;

use App\Models\Comment;

class CommentService
{
    public function create(array $data): Comment
    {
        return Comment::create($data);
    }

    public function update(Comment $comment,array $data): Comment
    {
        $comment->update($data);

        return $comment->refresh();
    }

    public function delete(Comment $comment): void
    {
        $comment->delete();
    }
}
