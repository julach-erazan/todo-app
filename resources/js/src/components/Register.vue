<template>
    <div class="register-container">
        <div class="register-wrapper">
            <h1 class="font-bold text-[20px]">Register</h1>
            <form @submit.prevent="handleRegister">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input
                        type="text"
                        id="name"
                        v-model="name"
                        placeholder="Enter your full name"
                        required
                    />
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input
                        type="email"
                        id="email"
                        v-model="email"
                        placeholder="Enter your email"
                        required
                    />
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        v-model="password"
                        placeholder="Enter your password"
                        required
                    />
                </div>
                <button type="submit">Register</button>
            </form>
            <p class="my-[10px]">
                Already have an account?
                <router-link to="/login" class="text-[blue]">
                    Login now
                </router-link>
            </p>

            <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>
            <p v-if="successMessage" class="success-message">
                {{ successMessage }}
            </p>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {

    data() {
        return {
            name: "",
            email: "",
            password: "",
            errorMessage: "",
            successMessage: "",
        };
    },
    methods: {
        async handleRegister() {
            try {
                // Call the Laravel API endpoint for registration
                const response = await axios.post(`http://127.0.0.1:8000/register`, {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                });

                // Handle success response
                this.successMessage = response.data.message || "Registration successful.";
                this.errorMessage = "";
                this.resetForm();

                // Optionally redirect the user to the login page
                this.$router.push("/login");
            } catch (error) {
                // Handle error response
                console.log(error)
            }
        },
        resetForm() {
            this.name = "";
            this.email = "";
            this.password = "";
        },
    },
};
</script>

<style scoped>
.register-container {
    width: 100vw;
    height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
.register-wrapper {
    width: 100%;
    max-width: 400px;
    min-width: 250px;
    margin: auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

button {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
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
