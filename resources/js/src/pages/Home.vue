<template>
    <div>
        <navbar></navbar>
        <div class="container">
            <div class="row mt-5">
                <div class="col-md-3">
                    <sidebar @search="searchBlog"></sidebar>
                </div>
                <div class="col-md-9">
                    <blog-list :data="blogs"></blog-list>
                </div>
            </div>
        </div>
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
    search = {
        username: '',
        category: []
    };

    get blogs() {
        let blog = Blog.query();

        if (this.search.username) blog.where(blog => blog.title.includes(this.search.username));
        if (this.search.category.length > 0) blog.where(blog => {
            for (let category of this.search.category) {
                if (!blog.categories.map(category => category.id).includes(category)) {
                    return false;
                }
            }

            return true;
        });

        return blog.get();
    }

    searchBlog(key: string, keyword: string) {
        this.search[key] = keyword;
    }
}
</script>
