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
     * @param array<mixed> $aData
     * @return mixed
     */
    public function saveTodo(array $aData): mixed
    {
        return $this->oTodo->create($aData);
    }

    /**
     * Check if the id exists then set the completed field to true
     * @param array<mixed> $aTodo
     * @return mixed
     */
    public function updateTodo(array $aTodo): mixed
    {
        return $this->oTodo
            ->whereIn('id', $aTodo)
            ->update([
                'completed' => true
            ]);
    }

    /**
     * Get the actual list
     * @return mixed
     */
    public function getTodoList(): mixed
    {
        return $this->oTodo->get();
    }

    /**
     * Delete multiple todos
     * @param array<mixed> $aTodo
     * @return mixed
     */
    public function deleteTodo(array $aTodo): mixed
    {
        return $this->oTodo->whereIn('id', $aTodo)->delete();
    }
}