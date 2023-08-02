<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteTodoRequest;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Services\TodoService;
use App\Models\Todo;

/**
 * Class TodoController
 * @package App\Http\Controllers
 * @author Richmark <richmark.jinn.ravina@gmail.com>
 * @date 08/01/2023 5:54 PM
 */
class TodoController extends Controller
{
    /**
     * @var Todo $oTodoModel
     */
    private Todo $oTodoModel;

    /**
     * @param TodoService $oTodoService
     * constructor to inject TodoService layer
     */
    public function __construct(Todo $oTodoModel)
    {
        $this->oTodoModel = $oTodoModel;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $oTodos = $this->oTodoModel->query()->get();

        return inertia('Todos/Index', [
            'todos' => $oTodos,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTodoRequest $oRequest)
    {
        $aValidatedData = $oRequest->validated();
        $this->oTodoModel->create($aValidatedData);

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTodoRequest $oRequest)
    {
        $aValidatedData = $oRequest->validated();
        $this->oTodoModel
            ->findOrFail($aValidatedData['id'])
            ->update([
                'completed' => $aValidatedData['completed']
            ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteTodoRequest $oRequest)
    {
        $aValidatedData = $oRequest->validated();
        $this->oTodoModel->findOrFail($aValidatedData['id'])->delete();

        return redirect()->back();
    }
}
