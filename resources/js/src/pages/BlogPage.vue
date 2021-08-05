<template>
    <div v-if="blog" class="container my-5">
        <a href="#" @click="$router.go(-1)" class="text-decoration-none">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        <br><br>
        <h1 class="d-inline mt-3">{{ blog.title }}</h1>
        <div v-if="blog.user_id === $user.id" class="float-end">
            <button @click="$router.push('/blog/' + id + '/edit')" class="btn btn-primary">Edit</button>
            <button @click="deleteBlog" class="btn btn-primary">Delete</button>
        </div>
        <br>
        <span v-for="category in blog.categories" class="badge bg-secondary me-2">{{ category.name }}</span>
        <div class="small-text mt-2" style="text-transform: none">
            Posted by: {{ blog.user.name }} - {{ blog.created_at | moment('MMM DD, YYYY') }}
        </div>
        <hr>
        <img :src="blog.image" alt="" style="max-width: 500px" class="d-block mx-auto">
        <hr class="mx-auto" style="width: 5%">
        <p style="text-indent: 50px">{{ blog.content }}</p>
        <blog-comment :data="blog"></blog-comment>
    </div>
</template>

<script lang="ts">
import Vue from '@/lib/vue';
import { Component } from 'vue-property-decorator';
import Blog from '@/models/blog';
import Navbar from '@/components/Navbar.vue';
import BlogComment from '@/components/BlogComment.vue';

@Component({
    components: { BlogComment, Navbar }
})
export default class BlogPage extends Vue {
    id!: number;

    async created() {
        this.id = +this.$route.params.id;
        await Blog.fetchById(this.id);

        if (!this.blog) await this.$router.push('/home');
    }

    get blog() {
        return Blog.find(this.id);
    }

    async deleteBlog() {
        if (!confirm('Delete this blog?')) return;

        await this.$http.delete('/api/blogs/' + this.id);
        await Blog.delete(this.id);

        await this.$router.push('/home');
    }
}
</script>
