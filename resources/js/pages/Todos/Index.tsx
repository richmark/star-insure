import React from "react";
import Layout from "@/layouts/Layout";
import { Todo } from "@/types";
import Modal from "@/components/common/Modal";
import TodoForm from "@/components/TodoForm";
import Button from "@/components/common/Button";
import Card from "@/components/common/Card";
import { useForm } from "@inertiajs/react";
import { useSubmit } from "@/lib/forms";

interface Props {
    todos: Todo[];
}

export default function TodosIndex({ todos }: Props) {
    const [modalOpen, setModalOpen] = React.useState(false);
    const { put, delete: deleteTodo } = useForm();

    const onDelete = useSubmit({
        message: "Deleted Successfully!",
    });

    const onUpdate = useSubmit({
        message: "Updated Successfully!",
    });

    function handleDeleteTodo(id: number) {
        if (confirm("Are you sure you want to delete this todo?")) {
            deleteTodo(`/todos/${id}`, onDelete);
        }
    }

    function handleUpdateTodo(id: number) {
        if (confirm("Are you sure you want to update the status?")) {
            put(`/todos/${id}`, onUpdate);
        }
    }

    return (
        <Layout>
            <div className="container mt-12 mb-24">
                <div className="flex flex-col gap-12">
                    <Button
                        type="button"
                        onClick={() => setModalOpen(!modalOpen)}
                        className="mr-auto"
                    >
                        Add ToDo
                    </Button>

                    {todos.map((todo) => (
                        <Card
                            key={todo.id}
                            className="flex justify-between gap-x-6 py-5"
                        >
                            <div className="flex gap-x-4">
                                <div className="min-w-0 flex-auto">
                                    <p className="text-sm font-semibold leading-6 text-gray-900">
                                        Title: {todo.title}
                                    </p>
                                    <p className="mt-1 truncate text-xs leading-5 text-gray-500">
                                        Created: {todo.created_at}
                                    </p>
                                    <p className="mt-1 truncate text-xs leading-5 text-gray-500">
                                        Updated: {todo.updated_at}
                                    </p>
                                    <p className="mt-1 truncate text-xs leading-5 text-gray-500">
                                        Status:{" "}
                                        {todo.completed ? "Completed" : "Todo"}
                                    </p>
                                </div>
                            </div>
                            <div className="hidden sm:flex sm:flex-col sm:items-end">
                                <p className="text-sm leading-6 text-gray-900">
                                    {todo.completed === false ? (
                                        <Button
                                            type="button"
                                            onClick={() =>
                                                handleUpdateTodo(todo.id)
                                            }
                                            className="mr-5"
                                        >
                                            Update
                                        </Button>
                                    ) : (
                                        ""
                                    )}

                                    <Button
                                        type="button"
                                        onClick={() =>
                                            handleDeleteTodo(todo.id)
                                        }
                                        className="mr-5"
                                        theme="danger"
                                    >
                                        Delete
                                    </Button>
                                </p>
                            </div>
                        </Card>
                    ))}
                </div>
            </div>

            <Modal show={modalOpen} onClose={() => setModalOpen(false)}>
                <TodoForm closeModal={() => setModalOpen(false)} />
            </Modal>
        </Layout>
    );
}
