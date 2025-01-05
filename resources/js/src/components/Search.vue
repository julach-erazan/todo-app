<template>
    <div>
        <Navbar :userName="userName" :imageURL="imageURL" @logout="logout" />
        <div
            class="search-container mt-[60px] flex justify-center w-full h-[70px] bg-white fixed top-0 left-0 z-50"
        >
            <input
                type="text"
                v-model="searchQuery"
                @input="handleSearch"
                placeholder="Search posts..."
                class="search-input min-w-[200px] max-w-[500px] h-[50px] px-4 border rounded-md border-[#ccc]"
            />
        </div>

        <div class="posts-container mt-[150px]">
            <div v-if="isLoading" class="text-center">
                <h1 class="text-[20px] font-bold">Loading...</h1>
            </div>

            <div v-else-if="results.length === 0" class="text-center">
                <h1 class="text-[20px] font-bold">No Results Available</h1>
            </div>

            <ul v-else class="flex flex-col items-center gap-5">
                <li v-for="post in results" :key="post.task_id" class="w-[80%] flex flex-col items-center">
                    <div
                        class="post-container w-[80%] min-h-[500px] border-solid border-[#ccc] border-[1px] rounded-[20px] flex flex-col justify-between"
                    >
                        <div
                            class="user border-solid border-[#ccc] border-b-[1px] h-[50px] flex flex-row justify-between items-center px-[20px]"
                        >
                            <div
                                class="profile flex flex-row items-center gap-[10px]"
                            >
                                <img
                                    :src="`http://localhost:8000/storage/${imageURL}`"
                                    alt="profile image"
                                    class="w-[30px] h-[30px] rounded-[50%]"
                                />
                                <p>{{ userName }}</p>
                            </div>
                            <div>
                                <h1>{{ post.createdDate }}</h1>
                            </div>
                        </div>
                        <div
                            class="post min-h-[300px] flex flex-row flex-wrap md:justify-between justify-center items-center p-[20px]"
                        >
                            <img
                                :src="`http://localhost:8000/storage/${post.image_url}`"
                                alt="post image"
                                class="w-[300px] h-[300px] object-cover rounded-[20px]"
                            />
                            <div class="min-w-[300px] w-[50%] h-[300px]">
                                <h1 class="text-[25px] font-bold text-center">
                                    {{ post.title }}
                                </h1>
                                <p class="mt-[15px]">{{ post.description }}</p>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import Navbar from "./Navbar.vue";
import axios from "axios";

export default {
    components: {
        Navbar,
    },
    data() {
        return {
            userName: localStorage.getItem("userName"),
            imageURL: localStorage.getItem("imageURL"),
            posts: [],
            searchQuery: "",
            isLoading: false,
            results: [],
        };
    },
    methods: {
        // Handles the search functionality
        async handleSearch() {
            if (this.searchQuery.trim() === "") {
                this.results = []; // Clear the results if search is empty
                return;
            }

            this.isLoading = true;
            try {
                const response = await axios.get(
                    "http://127.0.0.1:8000/post/search",
                    {
                        params: { query: this.searchQuery },
                    }
                );
                this.results = response.data.tasks;
            } catch (error) {
                console.error("Error fetching search results:", error);
            } finally {
                this.isLoading = false;
            }
        },
    },
};
</script>
