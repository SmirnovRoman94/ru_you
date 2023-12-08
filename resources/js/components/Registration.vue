<template>
    <h1>Registration</h1>
    <div class="w-25">
        <input v-model="name" type="text" placeholder="name" class="form-control mb-3 mt-3">
        <input v-model="email" type="email" placeholder="email" class="form-control mb-3">
        <input v-model="password" type="password" placeholder="password" class="form-control mb-3">
        <input v-model="password_confirmation" type="password" placeholder="password_confirmation" class="form-control mb-3">
        <input type="submit" value="register" @click.prevent="register" class="btn btn-primary">
    </div>
</template>

<script setup>
import {ref} from "vue";
import axios from "axios";
import {useRouter} from "vue-router";

const router = useRouter();

//registration
const name = ref('');
const email = ref('');
const password = ref('');
const password_confirmation = ref('');

function register(){
    axios.post('/api/users', {
        name: name.value,
        email: email.value,
        password: password.value,
        password_confirmation: password_confirmation.value
    })
        .then((res) => {
            console.log(res)
            if(res.data.mess === 1){
                console.log('такой пользовтаель уже есть')
            }
            if(res.data.mess === 2){
                localStorage.access_token = res.data.access_token;
                router.push({name: 'user.personal'})
                this.$emit('updateToken', true)
            }
        })
}


</script>

<style scoped>

</style>
