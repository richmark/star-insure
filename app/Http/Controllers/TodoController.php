<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteTodoRequest;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Models\Todo;
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
     * @var Todo $oTodoModel
     */
    private Todo $oTodoModel;

    /**
     * Constructor to inject TodoModel layer
     * @param Todo $oTodoModel
     */
    public function __construct(Todo $oTodoModel)
    {
        $this->oTodoModel = $oTodoModel;
    }

    /**
     * Display a listing of the resource
     * @return ResponseFactory|Response
     */
    public function index(): ResponseFactory|Response
    {
        $oTodos = $this->oTodoModel->query()->orderBy('created_at', 'desc')->get();

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
        $this->oTodoModel->create($aValidatedData);

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage
     * @return RedirectResponse
     */
    public function update(UpdateTodoRequest $oRequest): RedirectResponse
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
     * Remove the specified resource from storage
     * @return RedirectResponse
     */
    public function destroy(DeleteTodoRequest $oRequest): RedirectResponse
    {
        $aValidatedData = $oRequest->validated();
        $this->oTodoModel->findOrFail($aValidatedData['id'])->delete();

        return redirect()->back();
    }
}
