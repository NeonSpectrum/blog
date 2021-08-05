<template>
    <div>
        <div v-show="shown" class="modal fade" :class="{show: shown}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form @submit.prevent="save">
                        <div class="modal-header">
                            <h5 class="modal-title">Add User</h5>
                            <button @click="shown = false" type="button" class="btn-close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-floating mb-3">
                                <input v-model="$v.name.$model" type="text" id="name" class="form-control"
                                       placeholder="..."
                                >
                                <label for="name">Name</label>
                                <div v-show="$v.name.$dirty && !$v.name.required" class="invalid-feedback">
                                    Please choose a username.
                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <input v-model="$v.username.$model" type="text" id="username" class="form-control"
                                       placeholder="..."
                                >
                                <label for="username">Username</label>
                                <div v-show="$v.username.$dirty && !$v.username.required" class="invalid-feedback">
                                    Please choose a name.
                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <select v-model="$v.userType.$model" type="text" id="userType" class="form-control">
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                </select>
                                <label for="userType">User Type</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input v-model="$v.password.$model" type="password" id="password" class="form-control"
                                       placeholder="..."
                                >
                                <label for="password">Password</label>
                                <div v-show="$v.password.$dirty && !$v.password.required" class="invalid-feedback">
                                    Please choose a password.
                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <input v-model="$v.confirmPassword.$model" type="password" id="confirmPassword"
                                       class="form-control"
                                       placeholder="..."
                                >
                                <label for="confirmPassword">Confirm Password</label>
                                <div v-show="$v.confirmPassword.$dirty && !$v.confirmPassword.invalid"
                                     class="invalid-feedback"
                                >
                                    Invalid confirm password.
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button @click="shown = false" type="button" class="btn btn-secondary">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div v-if="shown" class="modal-backdrop show"></div>
    </div>
</template>

<script lang="ts">
import Vue from '@/lib/vue';
import { Component, Inject } from 'vue-property-decorator';
import { Action } from 'vuex-class';
import { User } from '@/types';
import { required } from 'vuelidate/lib/validators';
import { Validations } from 'vuelidate-property-decorators';

@Component
export default class UserManage extends Vue {
    @Action('setUser') setUser;
    @Inject() fetchData;

    shown: boolean = false;

    name: string = '';
    username: string = '';
    password: string = '';
    userType: string = 'user';
    confirmPassword: string = '';

    @Validations()
    validations() {
        return {
            name: { required },
            username: { required },
            password: { required },
            userType: { required },
            confirmPassword: { required, invalid: value => value === this.password }
        };
    }

    showModal(value: boolean) {
        this.shown = value;
    }

    async save() {
        this.$v?.$touch();

        if (this.$v?.$invalid) return;

        let response = await this.$http.post('/api/users', {
            name: this.name,
            username: this.username,
            password: this.password,
            userType: this.userType
        });

        alert(response.data.message);

        if (response.data.success === false) return;

        this.shown = false;
        await this.fetchData();
    }
}
</script>
