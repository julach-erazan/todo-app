<template>
    <div class="login-container">
        <div class="login-wrapper">
            <h1 class="font-bold text-[20px]">Login</h1>
            <form @submit.prevent="handleLogin">
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
                <button type="submit">Login</button>
            </form>
            <p class="my-[10px]">
                Don't have an account?
                <router-link to="/register" class="text-[blue]">
                    Signup now
                </router-link>
            </p>
            <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      email: "",
      password: "",
      errorMessage: "",
      loading: false,
    };
  },
  methods: {
    async handleLogin() {
      this.loading = true;
      this.errorMessage = ""; // Clear any previous error messages

      try {
        // Send login request to the backend
        const response = await axios.post("http://127.0.0.1:8000/user/login", {
          email: this.email,
          password: this.password,
        }
        );

        // If successful, store token and redirect
        if (response.data.success) {
          localStorage.setItem("token", response.data.token); // Store token
          localStorage.setItem("email", response.data.user.email); // Store email
          localStorage.setItem("userId", response.data.user.id); // userId email
          this.$router.push("/dashboard"); // Redirect to dashboard
        } else {
          this.errorMessage = response.data.message; // Show error from backend
        }
      } catch (error) {
        this.errorMessage = error.response?.data?.message || "An error occurred during login.";
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>

<style scoped>
.login-container {
    width: 100vw;
    height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.login-wrapper {
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
</style>
