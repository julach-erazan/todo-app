<template>
    <div class="dashboard-container">
        <Navbar :userName="userName" @logout="logout" />
        <div class="todo-container">
            <h1 class="font-bold text-[25px]">Todo Dashboard</h1>

            <!-- Add Todo Section -->
            <div class="add-todo">
                <h2>Add Todo</h2>
                <form @submit.prevent="addTodo">
                    <input
                        type="text"
                        v-model="newTodoText"
                        placeholder="Enter a new todo"
                        required
                        :disabled="loading"
                    />
                    <button type="submit" :disabled="loading">
                        {{ loading ? "Adding..." : "Add" }}
                    </button>
                </form>
            </div>

            <!-- Todo List Section -->
            <div class="todo-list">
                <h2>Todo List</h2>
                <div v-if="loading">Loading todos...</div>
                <div v-else-if="todos.length === 0">
                    No todos available. Add one!
                </div>
                <ul>
                    <li v-for="(todo, index) in todos" :key="todo.id">
                        <div class="todo-item">
                            <div v-if="editingIndex !== index">
                                {{ todo.text }}
                            </div>
                            <input
                                v-else
                                type="text"
                                v-model="editedTodoText"
                                @keyup.enter="updateTodo(index)"
                            />
                            <div class="actions">
                                <button
                                    v-if="editingIndex !== index"
                                    @click="editTodo(index)"
                                >
                                    Edit
                                </button>
                                <button
                                    v-if="editingIndex === index"
                                    @click="updateTodo(index)"
                                >
                                    Save
                                </button>
                                <button @click="deleteTodo(index)">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Navbar from "./Navbar.vue";

export default {
    components: {
        Navbar,
    },
    data() {
        return {
            userName: localStorage.getItem("email"),
            todos: [],
            newTodoText: "",
            editingIndex: null,
            editedTodoText: "",
            loading: false,
            error: null,
        };
    },
    methods: {
        // Fetch todos from the backend
        async fetchTodos() {
            const userId = localStorage.getItem("userId");

            this.loading = true;
            try {
                const response = await axios.get(
                    `http://127.0.0.1:8000/tasks/view?user_id=${userId}`
                );
                this.todos = response.data.tasks;
            } catch (error) {
                console.error("Error fetching todos:", error);
                this.error = "Failed to fetch todos.";
            }
        },
        // Add a new todo
        async addTodo() {
            const userId = localStorage.getItem("userId");

            if (this.newTodoText.trim() !== "") {
                this.loading = true;
                try {
                    const response = await axios.post(
                        "http://127.0.0.1:8000/tasks/add",
                        {
                            text: this.newTodoText.trim(),
                            user_id: userId,
                        }
                    );

                    const newTask = response.data.task;
                    this.todos.push(newTask);
                    this.newTodoText = "";
                } catch (error) {
                    console.error("Error adding todo:", error);
                    this.error = "Failed to add todo.";
                } finally {
                    this.loading = false;
                }
            }
        },

        // Edit an existing todo
        // editTodo(index) {
        //     this.editingIndex = index;
        //     this.editedTodoText = this.todos[index].text;
        // },
        // Update the todo after editing
        // async updateTodo(index) {
        //     if (this.editedTodoText.trim() !== "") {
        //         const todo = this.todos[index];
        //         this.loading = true;
        //         try {
        //             await axios.put(`${process.env.VUE_APP_API_URL}/tasks/${todo.id}`, {
        //                 text: this.editedTodoText.trim(),
        //             });
        //             this.todos[index].text = this.editedTodoText.trim();
        //             this.editingIndex = null;
        //             this.editedTodoText = "";
        //         } catch (error) {
        //             console.error("Error updating todo:", error);
        //             this.error = "Failed to update todo.";
        //         } finally {
        //             this.loading = false;
        //         }
        //     }
        // },

        // Delete a todo
        async deleteTodo(index) {
            const todo = this.todos[index];
            this.loading = true;
            try {
                await axios.delete(`http://127.0.0.1:8000/tasks/delete/${todo.id}`);
                this.todos.splice(index, 1);
            } catch (error) {
                console.error("Error deleting todo:", error);
                this.error = "Failed to delete todo.";
            } finally {
                this.loading = false;
            }
        },
    },
    async created() {
        await this.fetchTodos();
    },
};
</script>

<style scoped>
.dashboard-container {
    width: 100vw;
    display: flex;
    justify-content: center;
}

.todo-container {
    width: 80%;
    min-width: 400px;
    min-width: 250px;
    margin-top: 100px;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1,
h2 {
    text-align: center;
}

.add-todo {
    margin-bottom: 20px;
}

input {
    padding: 10px;
    margin-right: 10px;
    width: calc(100% - 90px);
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
}

button {
    padding: 10px 15px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}

.todo-list ul {
    list-style: none;
    padding: 0;
}

.todo-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    border-bottom: 1px solid #ccc;
}

.actions button {
    margin-left: 5px;
    background-color: #28a745;
}

.actions button:last-child {
    background-color: #dc3545;
}

.actions button:hover {
    opacity: 0.8;
}
</style>
