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
                                <input v-model="name" type="text" id="name" class="form-control" placeholder="...">
                                <label for="name">Name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input v-model="username" type="text" id="username" class="form-control"
                                       placeholder="..."
                                >
                                <label for="username">Username</label>
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
import { User } from '@/types';
import { Action } from 'vuex-class';

@Component
export default class UserManage extends Vue {
    @Action('setUser') setUser;
    @Inject() fetchData;

    user?: User;

    shown: boolean = false;

    name: string = '';
    username: string = '';

    showModal(user, value: boolean) {
        this.user = user;
        this.shown = value;

        if (this.user) {
            this.name = this.user.name;
            this.username = this.user.username;
        }
    }

    getData() {
        return {
            name: this.name,
            username: this.username
        };
    }

    add() {
        return this.$http.post('/api/users', this.getData());
    }

    edit() {
        return this.$http.put('/api/users/' + this.user?.id, this.getData());
    }

    async save() {
        let response = await (!this.user ? this.add() : this.edit());

        alert(response.data.message);

        if (this.user?.id === this.$user.id) {
            this.setUser(this.getData());
        }

        this.shown = false;
        await this.fetchData();
    }
}
</script>
