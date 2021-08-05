<template>
    <transition name="fade">
        <div>
            <navbar v-if="navbar && $route.name !== 'login'"></navbar>
            <loader v-if="loaderCount > 0"></loader>
            <div v-else class="wrapper">
                <router-view></router-view>
            </div>
        </div>
    </transition>
</template>

<script lang="ts">
import Vue from '@/lib/vue';
import { Component, Provide, Watch } from 'vue-property-decorator';
import Loader from '@/components/Loader.vue';
import { Action } from 'vuex-class';
import Category from '@/models/category';
import Blog from '@/models/blog';
import Navbar from '@/components/Navbar.vue';

@Component({
    components: { Navbar, Loader }
})
export default class App extends Vue {
    @Action('setUser') setUser;

    loaderCount: number = 1;
    navbar: boolean = false;

    async mounted() {
        if (this.$route.name === 'login') {
            return this.loader(false);
        }

        if (!await this.checkSession()) {
            this.loader(false);
            return await this.$router.push({ name: 'login' });
        }

        this.navbar = true;
        await Promise.all([Blog.fetch(), Category.fetch()]);
        this.loader(false);
    }

    @Watch('$route.name')
    async refreshData(value) {
        if (value === 'home' || value === 'me') {
            this.loader(true);
            await Blog.fetch();
            this.loader(false);
        }
    }

    @Provide()
    async checkSession() {
        if (!this.$checkToken()) return false;

        let response = await this.$http.get('/api/user');

        this.setUser(response.data.user);

        return response.data.user !== null;
    }

    loader(value: boolean) {
        this.loaderCount += value ? 1 : -1;
    }
}
</script>
