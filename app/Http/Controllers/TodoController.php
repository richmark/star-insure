<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Services\TodoService;

/**
 * Class TodoController
 * @package App\Http\Controllers
 * @author Richmark <richmark.jinn.ravina@gmail.com>
 * @date 08/01/2023 5:54 PM
 */
class TodoController extends Controller
{
    /**
     * @var TodoService $oTodoService
     */
    private TodoService $oTodoService;

    /**
     * @param TodoService $oTodoService
     * constructor to inject TodoService layer
     */
    public function __construct(TodoService $oTodoService)
    {
        $this->oTodoService = $oTodoService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $oTodos = $this->oTodoService->getTodoList();

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
        $this->oTodoService->saveTodo($aValidatedData);

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTodoRequest $oRequest)
    {
        $aValidatedData = $oRequest->validated();
        $this->oTodoService->updateTodo($aValidatedData['id']);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UpdateTodoRequest $oRequest)
    {
        $aValidatedData = $oRequest->validated();
        $this->oTodoService->deleteTodo($aValidatedData['id']);

        return redirect()->back();
    }
}
