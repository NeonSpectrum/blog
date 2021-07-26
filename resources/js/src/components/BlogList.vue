<template>
    <div>
        <div class="blog-no-result" v-if="data.length === 0">
            No Results Found
        </div>
        <div v-else class="blog-list">
            <div @click="$router.push('/blog/' + blog.id)" v-for="blog in data" class="card shadow">
                <img class="card-img-top" :src="blog.image || 'https://via.placeholder.com/350x200'"
                     alt="Card image cap" height="200" style="object-fit: cover"
                >
                <div class="card-body">
                    <div class="small-text">
                        {{ blog.categories.map(category => category.name).join(', ') }}
                        - {{ blog.created_at | moment('MMM DD, YYYY') }}
                    </div>
                    <h5 class="card-title">{{ blog.title }}</h5>
                    <p class="card-text">{{ lodash.truncate(blog.content, { length: 100 }) }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from '@/lib/vue';
import { Component, Prop } from 'vue-property-decorator';
import BlogComment from '@/components/BlogComment.vue';

@Component({
    components: { BlogComment }
})
export default class BlogList extends Vue {
    @Prop() data;
}
</script>
