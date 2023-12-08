<template>
    <h1>Login</h1>
    <div class="w-25">
        <input v-model="email" type="email" placeholder="email" class="form-control mb-3 mt-3">
        <input v-model="password" type="password" placeholder="password" class="form-control mb-3">
        <input type="submit" value="login" @click.prevent="login" class="btn btn-primary">
    </div>
</template>

<script>
import axios from "axios";
export default {
    name: "Login.vue",
    data() {
        return {
            email: '',
            password: '',
        }
    },
    methods: {
        login(){
            axios.post('api/auth/login', {
                email: this.email,
                password: this.password
            })
                .then(res => {
                    localStorage.access_token = res.data.access_token;
                    this.$router.push({name: 'user.personal'})
                    this.$emit('updateToken', true)
                })
                .catch(err => console.log(err))
        }
    },
}
</script>

<style scoped>

</style>
