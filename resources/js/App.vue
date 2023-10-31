<template>
    <div class="container">
        <div class="text-center" style="margin: 20px 0px 20px 0px;">
            <span class="text-secondary">Laravel Task</span>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse">
                <!-- for logged-in user-->
                <div class="navbar-nav" v-if="isLoggedIn">
                    <router-link to="/dashboard" class="nav-item nav-link">Dashboard</router-link>
                    <router-link to="/companies" class="nav-item nav-link">Companies</router-link>
                    <router-link to="/employees" class="nav-item nav-link">Employee</router-link>
                    <a class="nav-item nav-link" style="cursor: pointer;" @click="logout">Logout</a>
                </div>
                <!-- for non-logged user-->
                <div class="navbar-nav" v-else>
                    <router-link to="/" class="nav-item nav-link">Home</router-link>
                    <router-link to="/login" class="nav-item nav-link">login</router-link>
                    <router-link to="/register" class="nav-item nav-link">Register
                    </router-link>
                    <router-link to="/about" class="nav-item nav-link">About</router-link>
                </div>
            </div>
        </nav>
        <br/>
        <router-view/>
    </div>
</template>

<script>
export default {
    name: "App",
    data() {
        return {
            isLoggedIn: false,
        }
    },
    created() {
        let token  = localStorage.getItem('token')
        if (token) {
            this.isLoggedIn = true
        }
    },
    methods: {
        logout(e) {
            e.preventDefault()
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/logout')
                    .then(response => {
                        if (response.data.success) {
                            localStorage.removeItem('token');
                            window.Laravel.isLoggedin = false
                            this.isLoggedIn = false
                            window.location.href = "/"
                        } else {
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        }
    },
}
</script>
