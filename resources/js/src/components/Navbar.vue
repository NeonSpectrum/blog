<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow fixed-top">
        <div class="container">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <router-link to="/home" class="nav-link">
                        Home
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/me" class="nav-link">
                        My Blog
                    </router-link>
                </li>
                <li v-if="$user.user_type === 'admin'" class="nav-item">
                    <router-link to="/admin" class="nav-link">
                        User Management
                    </router-link>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item me-3">
                    <router-link to="/post" class="btn btn-primary" tag="button">
                        Post Blog
                    </router-link>
                </li>
                <li class="nav-item">
                    <span class="nav-link">
                        <img :src="'../../../images/profile.png'" alt="" height="20">
                        {{ user.username }}
                    </span>
                </li>
                <li class="nav-item dropdown">
                    <a @click.prevent="logout" href="/logout" class="nav-link">
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script lang="ts">
import Vue from '@/lib/vue';
import { Component } from 'vue-property-decorator';
import { Action, State } from 'vuex-class';

@Component
export default class Navbar extends Vue {
    @State('user') user;
    @Action('setUser') setUser;

    logout() {
        this.$cookies.remove('AUTH_TOKEN');
        this.setUser({});

        window.location.href = '/login';
    }
}
</script>
