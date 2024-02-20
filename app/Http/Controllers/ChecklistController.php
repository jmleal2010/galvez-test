<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChecklistRequest;
use App\Http\Resources\ChecklistResource;
use App\Models\Checklist;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ChecklistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $tasks = Checklist::all();
        return response()->json(ChecklistResource::collection($tasks));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(ChecklistRequest $request): JsonResponse
    {
        //Validación de la checklist
        $requestData = $request->validated();

        if ($requestData) {
            $checklist = Checklist::create($requestData);
            return response()->json($checklist, 201);
        }

        return response()->json($data = "", 400);
    }

    /**
     * Display the specified resource.
     */
    public function identify(Checklist $checklist): JsonResponse
    {

        $checklist = Checklist::findOrFail($checklist->id);

        return response()->json(new ChecklistResource($checklist));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ChecklistRequest $request, Checklist $checklist): JsonResponse
    {
        $validData = $request->validated();

      if($validData) {
          $checklist->update($validData);
      }

      return response()->json($checklist, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Checklist $checklist): JsonResponse
    {
        $checklist->deleteOrFail();

        return response()->json('No se ha podido eliminar el checklist', 500);
    }
}
