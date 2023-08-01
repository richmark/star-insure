<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Services\TodoService;
use Illuminate\Http\RedirectResponse;
use Inertia\ResponseFactory;
use Inertia\Response;

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
     * Constructor to inject TodoService layer
     * @param TodoService $oTodoService
     */
    public function __construct(TodoService $oTodoService)
    {
        $this->oTodoService = $oTodoService;
    }

    /**
     * Display a listing of the resource
     * @return ResponseFactory|Response
     */
    public function index(): ResponseFactory|Response
    {
        $oTodos = $this->oTodoService->getTodoList();

        return inertia('Todos/Index', [
            'todos' => $oTodos,
        ]);
    }

    /**
     * Store a newly created resource in storage
     * @return RedirectResponse
     */
    public function store(StoreTodoRequest $oRequest): RedirectResponse
    {
        $aValidatedData = $oRequest->validated();
        $this->oTodoService->saveTodo($aValidatedData);

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage
     * @return RedirectResponse
     */
    public function update(UpdateTodoRequest $oRequest): RedirectResponse
    {
        $aValidatedData = $oRequest->validated();
        $this->oTodoService->updateTodo($aValidatedData['ids']);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage
     * @return RedirectResponse
     */
    public function destroy(UpdateTodoRequest $oRequest): RedirectResponse
    {
        $aValidatedData = $oRequest->validated();
        $this->oTodoService->deleteTodo($aValidatedData['ids']);
        
        return redirect()->back();
    }
}
