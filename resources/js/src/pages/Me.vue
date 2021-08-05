<template>
    <div class="container">
        <blog-list :data="blogs"></blog-list>
    </div>
</template>

<script lang="ts">
import Vue from '@/lib/vue';
import { Component } from 'vue-property-decorator';
import BlogPost from '@/pages/BlogPost.vue';
import BlogList from '@/components/BlogList.vue';
import Navbar from '@/components/Navbar.vue';
import Sidebar from '@/components/Sidebar.vue';
import Blog from '@/models/blog';

@Component({
    components: { Sidebar, Navbar, BlogList, BlogPost }
})
export default class Home extends Vue {
    get blogs() {
        return Blog.query().where('user_id', this.$user.id).get();
    }
}
</script>
