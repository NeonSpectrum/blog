<template>
    <form @submit.prevent="submit">
        <div class="form-floating mb-3">
            <input v-model="name" type="text" id="name" class="form-control" placeholder="...">
            <label for="name">Name</label>
        </div>
        <div class="form-floating mb-3">
            <input v-model="username" type="text" id="username" class="form-control" placeholder="...">
            <label for="username">Username</label>
        </div>
        <div class="form-floating mb-3">
            <input v-model="password" type="password" id="password" class="form-control" placeholder="...">
            <label for="password">Password</label>
        </div>
        <div class="button-group">
            <button @click="show('login')" type="button" class="btn btn-light"><- Back</button>
            <button id="btnRegister" type="submit" class="btn btn-primary float-end">Register
            </button>
        </div>
    </form>
</template>

<script lang="ts">
import Vue from '@/lib/vue';
import { Component, Inject } from 'vue-property-decorator';

@Component
export default class RegisterForm extends Vue {
    @Inject('show') show;

    name: string = '';
    username: string = '';
    password: string = '';

    async submit() {
        let response = await this.$http.post('/register', {
            name: this.name,
            username: this.username,
            password: this.password
        });

        alert(response.data.message);

        if (response.data.success) {
            this.show('login');
        }
    }
}
</script>
