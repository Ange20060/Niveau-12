<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Http\Resources\ProjectResource;
use App\Services\ProjectService;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\UpdateProjectRequest;

class ProjectController extends Controller
{

    public function __construct(
      private ProjectService $projectService
    )
    {
      // service is injected via constructor property promotion
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::latest()->paginate(15);

        return ProjectResource::collection($projects);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FormRequest $request)
    {
      $project = $this->projectService->create(
        $request->validated()
      );

      return (new ProjectResource($project))
        ->response()
        ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return new ProjectResource($project);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $this->projectService->delete($project);

        return response()->noContent();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateProjectRequest $request,
        Project $project
    ) {
        $project = $this->projectService->update(
            $project,
            $request->validated()
        );

        return new ProjectResource($project);
    }
}
