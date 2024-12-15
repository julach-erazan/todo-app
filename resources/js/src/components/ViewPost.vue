<template>
    <Navbar :userName="userName" :imageURL="imageURL" @logout="logout" />
    <div class="pt-[80px]">
        <ul v-if="posts.length > 0">
            <li
                class="min-w-[500px] feed-container pt-[20px] flex flex-col items-center gap-[10px]"
                v-for="(post, index) in posts"
                :key="post.id"
            >
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
                    <div
                        class="actions border-solid border-[#ccc] border-t-[1px] h-[50px] flex flex-row items-center text-[15px] gap-[30px] px-[20px]"
                    >
                        <button 
                            class="text-[#04AA6D]"
                            @click="nevigateToEdit(post.id)"
                        >
                            <font-awesome-icon
                                :icon="['fas', 'arrows-rotate']"
                            />
                            Edit Post
                        </button>
                        <button
                            class="text-[#f44336]"
                            @click="deletePost(post.id)"
                        >
                            <font-awesome-icon :icon="['fas', 'trash']" />
                            Delete Post
                        </button>
                    </div>
                </div>
            </li>
        </ul>

        <div v-else class="text-center mt-[50px]">
            <h1 class="text-[20px] font-bold">No Posts Available</h1>
            <p class="text-[#555]">
                Looks like there are no posts yet. Create one to get started!
            </p>
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
            userName: localStorage.getItem("userName"),
            imageURL: localStorage.getItem("imageURL"),
            posts: [],
            fetchLoading: false,
            error: null,
        };
    },
    methods: {
        async fetchPosts() {
            const userId = localStorage.getItem("userId");
            this.fetchLoading = true;
            this.error = null;

            try {
                const response = await axios.get(
                    `http://127.0.0.1:8000/post/view?user_id=${userId}`
                );
                this.posts = response.data.tasks.map((task) => {
                    const date = new Date(task.created_at);
                    const createdDate = date.toLocaleDateString("en-US", {
                        year: "numeric",
                        month: "long",
                        day: "numeric",
                    });

                    return {
                        ...task,
                        createdDate,
                    };
                });
            } catch (error) {
                console.error("Error fetching posts:", error);
                this.error = "Failed to fetch posts.";
            } finally {
                this.fetchLoading = false;
            }
        },
        async deletePost(postId) {
            try {
                await axios.delete(
                    `http://127.0.0.1:8000/post/delete/${postId}`
                );

                // Update UI after deletion
                this.posts = this.posts.filter((post) => post.id !== postId);
            } catch (error) {
                console.error("Error deleting post:", error);
                this.error = "Failed to delete post. Please try again.";
            }
        },
        async nevigateToEdit(postId){
            this.$router.push({ name: "updatePost", params: { id: postId } });
        }
    },
    async created() {
        await this.fetchPosts();
    },
};
</script>
