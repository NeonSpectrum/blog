<template>
    <div>
        <table ref="table" style="width: 100%; margin-top: 20px !important">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Username</td>
                    <td>Name</td>
                    <td>Registration Date</td>
                    <td style="width: 10%">Action</td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in data">
                    <td>{{ user.id }}</td>
                    <td>{{ user.username }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.created_at | moment('MMMM DD, YYYY hh:mm:ss A') }}</td>
                    <td>
                        <button @click="showModal(user)" class="btn btn-primary btn-sm">Edit</button>
                        <button v-if="user.user_type !== 'admin'" @click="deleteUser(user.id)"
                                class="btn btn-primary btn-sm"
                        >
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <user-manage ref="userManage"></user-manage>
    </div>
</template>

<script lang="ts">
import Vue from '@/lib/vue';
import { Component, Prop, Ref } from 'vue-property-decorator';
import $ from 'jquery';
import { User } from '@/types';
import UserManage from '@/components/UserManage.vue';

@Component({
    components: { UserManage }
})
export default class UserList extends Vue {
    @Prop() data;
    @Ref() table;
    @Ref() userManage;

    currentUser = {};

    mounted() {
        $(this.table).DataTable({ autoWidth: false });
    }

    showModal(user: User) {
        this.userManage.showModal(user, true);
    }

    async deleteUser(id: number) {
        if (!confirm('Delete this user?')) return;

        await this.$http.delete('/api/users/' + id);

        alert('Deleted Successfully!');
    }
}
</script>
