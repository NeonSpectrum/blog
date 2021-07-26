<template>
    <div>
        <navbar></navbar>
        <div class="container mt-5">
            <h1 class="d-inline">User Management</h1>
            <button @click="addUser" class="btn btn-primary float-end">Add</button>
            <div class="card shadow mt-3">
                <div class="card-body">
                    <user-list ref="userList" v-if="isLoaded" :data="users"></user-list>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from '@/lib/vue';
import { Component, Provide, Ref } from 'vue-property-decorator';
import UserList from '@/components/UserList.vue';
import { User } from '@/types';
import Navbar from '@/components/Navbar.vue';

@Component({
    components: { Navbar, UserList }
})
export default class Admin extends Vue {
    @Ref() userList;

    users: User[] = [];

    isLoaded: boolean = false;

    async created() {
        if (this.$user.user_type !== 'admin') {
            await this.$router.replace('/home');
            return;
        }

        await this.fetchData();
    }

    @Provide('fetchData')
    async fetchData() {
        this.isLoaded = false;

        let response = await this.$http.get('/api/users');
        this.users = response.data;

        this.isLoaded = true;
    }

    addUser() {
        this.userList.showModal({});
    }
}
</script>
