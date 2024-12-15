<template>
    <Navbar :userName="userName" :imageURL="imageURL" @logout="logout" />
    <div class="post-wrapper w-full flex flex-col justify-center items-center">
        <div
            class="post-container w-[400px] min-h-[500px] mt-[100px] border-solid border-[#ccc] border-[1px] rounded-[20px]"
        >
            <form @submit.prevent="updatePost">
                <div
                    class="header h-[40px] border-solid border-[#ccc] border-b-[1px] px-[20px] flex items-center justify-between"
                >
                    <h1 class="text-[20px] font-bold">Update a post</h1>
                    <button type="submit" class="text-[18px] text-[#007bff]">
                        Save
                    </button>
                </div>

                <div class="px-[20px] py-[10px]">
                    <input
                        type="text"
                        v-model="title"
                        placeholder="Add a title"
                        required
                    />
                    <textarea
                        v-model="description"
                        placeholder="Add a description"
                        required
                    ></textarea>
                </div>
                <p v-if="errorMessage" class="error-message">
                    {{ errorMessage }}
                </p>
                <p v-if="successMessage" class="success-message">
                    {{ successMessage }}
                </p>
            </form>
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
    props: ["id"],
    data() {
        return {
            userName: localStorage.getItem("userName"),
            imageURL: localStorage.getItem("imageURL"),
            userId: localStorage.getItem("userId"),
            title: "",
            description: "",
            errorMessage: "",
            successMessage: "",
            post: [],
        };
    },
    mounted() {
        this.fetchPostDetails();
    },
    methods: {
        async fetchPostDetails() {
            try {
                const response = await axios.get(
                    "http://127.0.0.1:8000/post/filter",
                    {
                        params: {
                            user_id: this.userId,
                            task_id: this.id,
                        },
                    }
                );

                this.title = response.data.data.title;
                this.description = response.data.data.description;
            } catch (error) {
                console.error("Error fetching post:", error);
                this.errorMessage = "Error fetching post details.";
            }
        },

        async updatePost() {
            const payload = {
                title: this.title,
                description: this.description,
            };

            try {
                const response = await axios.put(
                    `http://127.0.0.1:8000/post/edit/${this.id}`,
                    payload,
                    {
                        headers: {
                            "Content-Type": "application/json",
                        },
                    }
                );

                this.successMessage = "Post updated successfully!";
                this.errorMessage = "";
            } catch (error) {
                console.error("Error updating post:", error);
                this.errorMessage = "Error updating post.";
                this.successMessage = "";
            }
        },
    },
};
</script>

<style scoped>
input,
textarea {
    width: 100%;
    margin-top: 10px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

textarea {
    min-height: 300px;
}

.error-message {
    color: red;
    text-align: center;
    margin-top: 10px;
}

.success-message {
    color: green;
    text-align: center;
    margin-top: 10px;
}
</style>
