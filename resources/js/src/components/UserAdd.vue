<template>
    <div>
        <div v-show="shown" class="modal fade" :class="{show: shown}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form @submit.prevent="save">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ !user.id ? 'Add User' : 'Editing ' + user.username }}</h5>
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

    user?: User | any = {};

    shown: boolean = false;

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

    showModal(user, value: boolean) {
        this.user = user;
        this.shown = value;

        if (this.user) {
            this.name = this.user.name;
        }
    }

    async save() {
        this.$v?.$touch();

        if (this.$v?.$invalid) return;

        let response = await this.$http.post('/api/users', {
            name: this.name,
            username: this.username,
            password: this.password
        });

        alert(response.data.message);

        this.shown = false;
        await this.fetchData();
    }
}
</script>
