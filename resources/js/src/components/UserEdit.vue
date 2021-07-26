<template>
    <div>
        <div v-show="shown" class="modal fade" :class="{show: shown}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form @submit.prevent="save">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ 'Editing ' + user.username }}</h5>
                            <button @click="shown = false" type="button" class="btn-close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-floating mb-3">
                                <input v-model="$v.name.$model" type="text" id="name" class="form-control"
                                       placeholder="..."
                                >
                                <label for="name">Name</label>
                                <div v-show="$v.name.$dirty && !$v.name.required" class="invalid-feedback">
                                    Please choose a name.
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
import { Validate } from 'vuelidate-property-decorators';

@Component
export default class UserManage extends Vue {
    @Action('setUser') setUser;
    @Inject() fetchData;

    user?: User | any = {};

    shown: boolean = false;

    @Validate({ required }) name: string = '';

    showModal(user, value: boolean) {
        this.user = user;
        this.shown = value;

        if (this.user) {
            this.name = this.user.name;
        }
    }

    getData() {
        return {
            name: this.name
        };
    }

    async save() {
        this.$v?.$touch();

        if (this.$v?.$invalid) return;

        let response = await this.$http.put('/api/users/' + this.user?.id, this.getData());

        alert(response.data.message);

        if (this.user?.id === this.$user.id) {
            this.setUser(this.getData());
        }

        this.shown = false;
        await this.fetchData();
    }
}
</script>
