<template>
    <form @submit.prevent="submit">
        <div class="form-floating mb-3">
            <input v-model="$v.name.$model" type="text" id="name" class="form-control" placeholder="...">
            <label for="name">Name</label>
            <div v-show="$v.name.$dirty && !$v.name.required" class="invalid-feedback">
                Please choose a username.
            </div>
        </div>
        <div class="form-floating mb-3">
            <input v-model="$v.username.$model" type="text" id="username" class="form-control" placeholder="...">
            <label for="username">Username</label>
            <div v-show="$v.username.$dirty && !$v.username.required" class="invalid-feedback">
                Please choose a name.
            </div>
        </div>
        <div class="form-floating mb-3">
            <input v-model="$v.password.$model" type="password" id="password" class="form-control" placeholder="...">
            <label for="password">Password</label>
            <div v-show="$v.password.$dirty && !$v.password.required" class="invalid-feedback">
                Please choose a password.
            </div>
        </div>
        <div class="form-floating mb-3">
            <input v-model="$v.confirmPassword.$model" type="password" id="confirmPassword" class="form-control"
                   placeholder="..."
            >
            <label for="confirmPassword">Confirm Password</label>
            <div v-show="$v.confirmPassword.$dirty && !$v.confirmPassword.invalid" class="invalid-feedback">
                Invalid confirm password.
            </div>
        </div>
        <div class="button-group">
            <button @click="show('login')" type="button" class="btn btn-light"><- Back</button>
            <button type="submit" class="btn btn-primary float-end">Register</button>
        </div>
    </form>
</template>

<script lang="ts">
import Vue from '@/lib/vue';
import { Component, Inject } from 'vue-property-decorator';
import { required } from 'vuelidate/lib/validators';
import { Validations } from 'vuelidate-property-decorators';

@Component
export default class RegisterForm extends Vue {
    @Inject('show') show;

    name: string = '';
    username: string = '';
    password: string = '';
    confirmPassword: string = '';

    @Validations()
    validations() {
        return {
            name: { required },
            username: { required },
            password: { required },
            confirmPassword: { required, invalid: value => value === this.password }
        };
    }

    async submit() {
        this.$v.$touch();

        if (this.$v.$invalid) return;

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
