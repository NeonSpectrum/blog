<template>
    <div v-if="data" class="mt-5">
        <h3>Comments</h3>
        <ul>
            <li v-for="comment in data.comments" class="d-flex position-relative">
                <a v-if="comment.user.id === $user.id" @click.prevent="deleteComment(comment.id)" href="#"
                   class="position-absolute"
                   style="top:0;right:0"
                >
                    <i class="fas fa-times"></i>
                </a>
                <img :src="'../../../images/profile.png'" alt="" height="40">
                <div class="ms-3">
                    <div style="font-weight: bold">{{ comment.user.username }}</div>
                    <div class="small-text">{{ $moment(comment.created_at).fromNow() }}</div>
                    <p>{{ comment.content }}</p>
                </div>
            </li>
        </ul>

        <form @submit.prevent="submit">
            <textarea @keypress.enter.prevent="submit" v-model="comment" class="form-control"></textarea>
            <button class="btn btn-primary mt-2">Comment</button>
        </form>
    </div>
</template>

<script lang="ts">
import Vue from '@/lib/vue';
import { Component, Prop } from 'vue-property-decorator';
import Blog from '@/models/blog';

@Component
export default class BlogComment extends Vue {
    @Prop() data!: Blog;

    comment: string = '';

    async submit() {
        if (this.comment.trim() === '') return;

        await this.$http.post('/api/blogs/' + this.data.id + '/comment', {
            comment: this.comment
        });

        await Blog.fetchById(this.data.id, {}, true);
        this.comment = '';
        window.scrollTo(0, document.body.scrollHeight);
    }

    async deleteComment(id: number) {
        if (!confirm('Delete this comment?')) return;

        await this.$http.delete('/api/comments/' + id);

        let blog = Blog.find(this.data?.id);

        if (blog) {
            blog.comments = blog.comments.filter(comment => comment.id !== id);
            await blog.$save();
        }
    }
}
</script>
