import React from "react";
import Layout from "@/layouts/Layout";
import { Todo } from "@/types";
import Modal from "@/components/common/Modal";
import TodoForm from "@/components/TodoForm";
import Button from "@/components/common/Button";
import Card from "@/components/common/Card";
import { useForm } from "@inertiajs/react";
import { handleChange, useSubmit } from "@/lib/forms";

interface Props {
    todos: Todo[];
}

export default function TodosIndex({ todos }: Props) {
    const [modalOpen, setModalOpen] = React.useState(false);

    const {
        data,
        setData,
        put,
        delete: deleteTodo,
    } = useForm({
        completed: false,
    });

    const onDelete = useSubmit({
        message: "Deleted Successfully!",
        preserveScroll: true,
    });

    const onUpdate = useSubmit({
        message: "Updated Successfully!",
        preserveScroll: true,
    });

    const handleDeleteTodo = (id: number) => {
        if (confirm("Are you sure you want to delete this todo?")) {
            deleteTodo(`/todos/${id}`, onDelete);
        }
    };

    const handleUpdateTodo = (
        event: React.MouseEvent<HTMLInputElement>,
        id: number,
        completed: boolean
    ) => {
        if (confirm("Are you sure you want to update the status?")) {
            data.completed = !completed;
            handleChange({ event, data, setData });
            put(`/todos/${id}`, onUpdate);
        }
    };

    return (
        <Layout>
            <div className="container mt-12 mb-24">
                <div className="mb-4 flex items-center justify-between gap-x-4">
                    <Button
                        type="button"
                        onClick={() => setModalOpen(!modalOpen)}
                        className="mr-auto"
                    >
                        Add ToDo
                    </Button>
                </div>

                {todos.length === 0 ? (
                    <Card className="flex justify-between gap-x-6 py-5">
                        <p>No records found</p>
                    </Card>
                ) : (
                    todos.map((todo) => (
                        <Card
                            key={todo.id}
                            className="flex justify-between gap-x-6 py-5"
                        >
                            <span className="flex-1">{todo.title}</span>
                            <Button
                                type="button"
                                onClick={(
                                    oEvent: React.MouseEvent<HTMLInputElement>
                                ) =>
                                    handleUpdateTodo(
                                        oEvent,
                                        todo.id,
                                        todo.completed
                                    )
                                }
                                className="mr-2 w-24"
                            >
                                {todo.completed ? "Completed" : "Todo"}
                            </Button>
                            <Button
                                type="button"
                                onClick={() => handleDeleteTodo(todo.id)}
                                theme="danger"
                            >
                                Delete
                            </Button>
                        </Card>
                    ))
                )}
            </div>

            <Modal show={modalOpen} onClose={() => setModalOpen(false)}>
                <TodoForm closeModal={() => setModalOpen(false)} />
            </Modal>
        </Layout>
    );
}
