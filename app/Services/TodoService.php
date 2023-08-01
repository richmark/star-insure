<?php

namespace App\Services;

use App\Models\Todo;

/**
 * Class TodoService
 * @package App\Http\Services
 * @author Richmark Jinn Ravina <richmark.jinn.ravina@gmail.com>
 * @date 08/01/2023 5:54 PM
 */
class TodoService
{
    /**
     * @var Todo $oTodo
     */
    private Todo $oTodo;

    /**
     * constructor to inject Todo model
     * @param Todo $oTodo
     */
    public function __construct(Todo $oTodo)
    {
        $this->oTodo = $oTodo;
    }

    /**
     * Actual saving of data
     * @param array $aData
     */
    public function saveTodo(array $aData)
    {
        return $this->oTodo->create($aData);
    }

    /**
     * Check if the id exists then set the completed field to true
     * @param int $iTodo
     */
    public function updateTodo(int $iTodo)
    {
        return $this->oTodo
            ->findOrFail($iTodo)
            ->update([
                'completed' => true
            ]);
    }

    /**
     * Get the actual list
     */
    public function getTodoList()
    {
        return Todo::query()->get();
    }

    /**
     * Check if the id exists then delete the todo
     * @param int $iTodo
     */
    public function deleteTodo(int $iTodo)
    {
        return $this->oTodo->findOrFail($iTodo)->delete();
    }
}