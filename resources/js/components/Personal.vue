<template>
    <h1>Personal</h1>
    <div class="mt-5">
        <h4>My friends</h4>
        <div v-for="item in friends" :key="item.id">
            <p>{{item.name}}</p>
        </div>
    </div>
    <div class="mt-5">
        <h3 class="border-bottom">All Users</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
            <tr  v-for="(user, index) in users" :key="user.id">
                <th scope="row">{{index+1}}</th>
                <td>{{user.name}}</td>
                <td>{{user.email}}</td>
                <td><button class="p-2 bg-primary text-center text-white" @click.stop="add(user.id)">Add frends</button></td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import API from "../api.js";
import axios from "axios";
export default {
    name: "Personal.vue",
    data() {
        return {
            users: [],
            friends: []
        }
    },
    methods: {
        getUsers(){
            API.get('api/auth/users')
                .then(res => {
                    if(res){
                        this.users = res.data
                    }
                })
        },
        add(userID){
            API.post(`api/auth/users/add`,{user: userID})
                .then(res => {
                    console.log(res)
                    if(res.data.mess === 1 ){
                        this.spliceUser(userID)
                    }
                })
        },
        spliceUser(id){
            this.users = this.users.filter(el => el.id != id);
            this.getFriends();
        },
        getFriends(){
            API.get('api/auth/users/friends')
                .then(res => {
                    if(res){
                        console.log(res)
                        this.friends = res.data;
                    }
                })
        },
    },
    mounted() {
        this.getUsers();
        this.getFriends()
    }
}
</script>

<style scoped>

</style>
