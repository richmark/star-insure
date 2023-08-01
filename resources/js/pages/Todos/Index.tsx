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
    const form = useForm<{ ids: number[] }>({
        ids: [], // Initialize ids as an empty array of numbers
    });

    const handleToggle = (id: number) => {
        const currentIds = form.data.ids;
        const updatedIds = currentIds.includes(id)
            ? currentIds.filter((selectedId) => selectedId !== id)
            : [...currentIds, id];

        form.setData("ids", updatedIds);
    };

    const onDelete = useSubmit({
        message: "Deleted Successfully!",
        onFinish() {
            resetData();
        },
    });

    const onUpdate = useSubmit({
        message: "Updated Successfully!",
        onFinish() {
            resetData();
        },
    });

    const resetData = () => {
        form.setData("ids", []);
    };

    const handleDeleteTodo = () => {
        if (form.data.ids.length === 0) {
            alert("Please select at least one todo to delete.");
            return;
        }

        if (confirm("Are you sure you want to delete the selected todo/s?")) {
            form.post("/todos/bulk-delete", onDelete);
        }
    };

    const handleUpdateTodo = () => {
        if (form.data.ids.length === 0) {
            alert("Please select at least one todo to update.");
            return;
        }

        if (confirm("Are you sure you want to update the status?")) {
            form.post("/todos/bulk-update", onUpdate);
        }
    };

    const checkIdStatus = () => {
        if (form.data.ids.length === 0) {
            return false;
        }

        const result = form.data.ids.some((selectedId) => {
            const matchedData = todos.find((todo) => todo.id === selectedId);
            if (matchedData && matchedData.completed === true) {
                return true;
            }
        });

        return result;
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

                    <Button
                        type="button"
                        onClick={() => handleUpdateTodo()}
                        className="px-4 py-2 text-white"
                        theme="info"
                        disabled={checkIdStatus()}
                    >
                        Update ToDo/s
                    </Button>

                    <Button
                        type="button"
                        onClick={() => handleDeleteTodo()}
                        className="px-4 py-2 text-white"
                        theme="danger"
                    >
                        Delete ToDo/s
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
                            <p className="mt-1 truncate text-xs leading-5 text-gray-500">
                                {todo.completed ? "Completed" : "Todo"}
                            </p>
                            <input
                                type="checkbox"
                                className="form-checkbox ml-4 h-5 w-5 text-blue-500"
                                checked={form.data.ids.includes(todo.id)}
                                onChange={() => handleToggle(todo.id)}
                            />
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
