<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Services\TaskService;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

class TaskController extends Controller
{
  public function __construct(
    private TaskService $taskService
  )
  {
  }
    /**
     * Display a listing of the resource.
     */
     public function index(Project $project)
     {
         $task = $project->task()
        ->latest()
        ->paginate(10);

        return TaskResource::collection($task);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request,
        Project $project
    ) {
        $task = $this->taskService->create([
            'project_id' => $project->id,
            ...$request->validated(),
        ]);

        return (new TaskResource($task))
            ->response()
            ->setStatusCode(201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( UpdateTaskRequest $request,
        Task $task
    ) {
        $task = $this->taskService->update(
            $task,
            $request->validated()
        );

        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->taskService->delete($task);

        return response()->noContent();
    }
}
