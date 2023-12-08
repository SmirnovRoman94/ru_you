<template>
    <router-link v-if="!token" :to="{name: 'user.login'}" class="px-1">Login</router-link>
    <router-link v-if="token" :to="{name: 'user.personal'}" class="px-1">Personal</router-link>
    <router-link v-if="!token" :to="{name: 'user.registration'}" class="px-1">Registration</router-link>
    <a v-if="token" @click.prevent="logout" href="#">Logout</a>
    <router-view @updateToken="updateItem"></router-view>
</template>

<script>
 import api from "../api.js";
 export default  {
     data() {
         return {
             token: false
         }
     },
     methods: {
         getToken(){
             this.token = localStorage.access_token;
         },
         logout(){
             api.post('/api/auth/logout')
                 .then(res => {
                     localStorage.clear()
                     this.$router.push({name: "user.login"})
                     this.token = false
                 })
         },
         updateItem(item){
             this.token = item;
         }
     },
     mounted() {
         this.getToken()
     },
 }

</script>

<style scoped>

</style>
