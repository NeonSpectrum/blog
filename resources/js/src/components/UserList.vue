<template>
    <div>
        <table ref="table" class="table table-striped" style="margin-top: 20px !important">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Username</td>
                    <td>Name</td>
                    <td>User Type</td>
                    <td>Registration Date</td>
                    <td style="width: 10%">Action</td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(user, key) in data">
                    <td>{{ key + 1 }}</td>
                    <td>{{ user.username }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ lodash.upperFirst(user.user_type) }}</td>
                    <td>{{ user.created_at | moment('MMMM DD, YYYY hh:mm:ss A') }}</td>
                    <td>
                        <button @click="showEditModal(user)" class="btn btn-primary btn-sm">Edit</button>
                        <button v-if="user.user_type !== 'admin'" @click="deleteUser(user.id)"
                                class="btn btn-primary btn-sm"
                        >
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <user-add ref="userAdd"></user-add>
        <user-edit ref="userEdit"></user-edit>
    </div>
</template>

<script lang="ts">
import Vue from '@/lib/vue';
import { Component, Inject, Prop, Ref } from 'vue-property-decorator';
import $ from 'jquery';
import { User } from '@/types';
import UserAdd from '@/components/UserAdd.vue';
import UserEdit from '@/components/UserEdit.vue';

@Component({
    components: { UserEdit, UserAdd  }
})
export default class UserList extends Vue {
    @Inject() fetchData;
    @Prop() data;
    @Ref() table;
    @Ref() userAdd;
    @Ref() userEdit;

    currentUser = {};

    mounted() {
        $(this.table).DataTable({ autoWidth: false });
    }

    showAddModal() {
        this.userAdd.showModal(true);
    }

    showEditModal(user: User) {
        this.userEdit.showModal(user, true);
    }

    async deleteUser(id: number) {
        if (!confirm('Delete this user?')) return;

        let response = await this.$http.delete('/api/users/' + id);

        alert(response.data.message);
    }
}
</script>
