<template>
  <nav class="navbar">
    <div class="navbar-left">
      <h1 class="app-title text-[#0067bc]">PostApp</h1>
    </div>

    <div class="w-[400px] h-[40px] text-[20px] flex flex-row justify-evenly items-center">
      <a>
        <router-link to="/dashboard" active-class="active-link">
          <font-awesome-icon 
            v-if="$route.path === '/dashboard'" 
            :icon="['fas', 'house']" 
          />
          <font-awesome-icon 
            v-else 
            :icon="['fas', 'house']" 
          />
        </router-link>
      </a>

      <a>
        <router-link to="/viewpost" active-class="active-link">
          <font-awesome-icon 
            v-if="$route.path === '/viewpost'"
            :icon="['fas', 'heart']" 
          />
          <font-awesome-icon 
            v-else
            :icon="['far', 'heart']" 
          />
        </router-link>
      </a>

      <a>
        <router-link to="/addpost" active-class="active-link">
        <font-awesome-icon 
            v-if="$route.path === '/addpost'"
            :icon="['fas', 'square-plus']" 
          />
          <font-awesome-icon 
            v-else
            :icon="['far', 'square-plus']" 
          />
        </router-link>
      </a>

      <a>
        <router-link to="/search" active-class="active-link">
           <font-awesome-icon 
            v-if="$route.path === '/search'"
            :icon="['fas', 'magnifying-glass']" 
          />
          <font-awesome-icon 
            v-else
            :icon="['fas', 'magnifying-glass']" 
          />
        </router-link>
      </a>
    </div>

    <div class="navbar-right">
      <div class="profileImg">
        <img 
          :src="`http://localhost:8000/storage/${imageURL}`" 
          alt="Profile Picture" 
        />
      </div>
      <span v-if="userName" class="user-name">Hi, {{ userName }}</span>
      <button v-if="userName" @click="handleLogout" class="logout-button">
        Logout
      </button>
    </div>
  </nav>
</template>

<script>
export default {
  props: {
    userName: {
      type: String,
      required: false,
    },
    imageURL: {
      type: String,
    }
  },
  methods: {
    handleLogout() {
      localStorage.setItem('isLoggedIn', false);
      localStorage.removeItem('token');
      localStorage.removeItem('userName');
      localStorage.removeItem('userId');
      localStorage.removeItem('imageURL');
      this.$router.push('/login');
    },
  },
};
</script>

<style scoped>
.navbar {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    background-color: #fff;
    color: #b4b4b4;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    position: fixed;
    z-index:100;
    top:0;
}

.app-title {
  font-size: 25px;
  font-weight: bold;
  margin: 0;
}

.navbar-left {
  display: flex;
  align-items: center;
}

.navbar-right {
  display: flex;
  align-items: center;
  gap: 15px;
}

.active-link{
  color: #0067bc;
  padding-bottom:3px;
  border-bottom: 2px solid #0067bc;

}

.profileImg img{
  width:35px; 
  height:35px;
  border-radius:50%;
}

.user-name {
  font-size: 1rem;
  font-weight: normal;
}

.logout-button {
  background-color: #ff4d4f;
  color: white;
  border: none;
  padding: 8px 12px;
  border-radius: 5px;
  cursor: pointer;
  font-size: 1rem;
}

.logout-button:hover {
  background-color: #d9363e;
}
</style>
