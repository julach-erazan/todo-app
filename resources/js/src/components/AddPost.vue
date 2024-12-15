<template>
    <Navbar :userName="userName" :imageURL="imageURL" @logout="logout" />
    <div class="post-wrapper w-full flex flex-col justify-center items-center">
        <div
            class="post-container w-[400px] min-h-[500px] mt-[100px] border-solid border-[#ccc] border-[1px] rounded-[20px]"
        >
            <form @submit.prevent="addPost" method="POST">
                <div
                    class="header h-[40px] border-solid border-[#ccc] border-b-[1px] px-[20px] flex items-center justify-between"
                >
                    <h1 class="text-[20px] font-bold">Create a post</h1>
                    <button type="submit" class="text-[18px] text-[#007bff]">
                        Post
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
                    <label for="image">Image</label>
                    <input type="file" id="image" @change="getImage" required />
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
    data() {
        return {
            userName: localStorage.getItem("userName"),
            imageURL: localStorage.getItem("imageURL"),
            title: "",
            description: "",
            image: null,
            errorMessage: "",
            successMessage: "",
        };
    },
    methods: {
        async addPost() {
            const userId = localStorage.getItem("userId");

            const formData = new FormData();
            formData.append("title", this.title);
            formData.append("description", this.description);
            formData.append("image_url", this.image);
            formData.append("user_id", userId);

            try {
                const response = await axios.post(
                    "http://127.0.0.1:8000/post/add",
                    formData,
                    {
                        headers: { "Content-Type": "multipart/form-data" },
                    }
                );

                this.successMessage =
                    response.data.message || "Post add successful.";
                this.errorMessage = "";
                this.resetForm();
            } catch (error) {
                console.error("Error adding post:", error);
                this.error = "Failed to add post.";
            }
        },
        getImage(event) {
            this.image = event.target.files[0];
        },
        resetForm() {
            this.title = "";
            this.description = "";
            image = null;
        },
    },
};
</script>

<style>
input,
textarea {
    width: 100%;
    margin-top: 10px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

textarea {
    min-height: 200px;
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
