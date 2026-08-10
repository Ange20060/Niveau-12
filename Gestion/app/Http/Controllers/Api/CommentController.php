<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Task;
use App\Services\CommentService;

class CommentController extends Controller
{
  public function __construct(
    private CommentService $commentService
  ) {
  }
    /**
     * Display a listing of the resource.
     */
    public function index(Task $task)
    {
        $comments = $task->comments()
            ->latest()
            ->paginate(10);

        return CommentResource::collection($comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( StoreCommentRequest $request,
        Task $task
    ) {
        $comment = $this->commentService->create([
            'task_id' => $task->id,
            'user_id' => $request->user()->id,
            'description' => $request->validated()['description'],
        ]);

        return (new CommentResource($comment))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request,
        Comment $comment
    ) {
        $comment = $this->commentService->update(
            $comment,
            $request->validated()
        );

        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $this->commentService->delete($comment);

        return response()->noContent();
    }
}
