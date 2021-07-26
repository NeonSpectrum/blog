<template>
    <form @submit.prevent="submit">
        <div class="form-floating mb-3">
            <input v-model="username" type="text" id="username" class="form-control" placeholder="...">
            <label for="username">Username</label>
        </div>
        <div class="form-floating mb-3">
            <input v-model="password" type="password" id="password" class="form-control" placeholder="...">
            <label for="password">Password</label>
        </div>
        <div class="button-group text-end">
            <button @click="show('register')" type="button" class="btn btn-light">Register</button>
            <button type="submit" class="btn btn-primary">Login</button>
        </div>
    </form>
</template>

<script lang="ts">
import Vue from '@/lib/vue';
import { Component, Inject } from 'vue-property-decorator';

@Component
export default class LoginForm extends Vue {
    @Inject('show') show;

    username: string = '';
    password: string = '';

    async submit() {
        let response = await this.$http.post('/login', {
            username: this.username,
            password: this.password
        });

        alert(response.data.message);

        if (response.data.success) {
            this.$setToken(response.data.token);
            await this.$router.push('/');
        }
    }
}
</script>
