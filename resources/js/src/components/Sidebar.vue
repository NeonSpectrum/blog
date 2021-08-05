<template>
    <div>
        <input @keyup="$emit('search', 'title', $event.target.value)" type="text" class="form-control"
               placeholder="Search..."
        >
        <div style="margin-top: 50px">
            <h4 class="mb-3">Categories</h4>
            <ul :key="selectedCategory.length" class="category-list">
                <li @click="selectCategory(category.id)" v-for="category in categories">
                    <i v-if="selectedCategory.includes(category.id)" class="fas fa-check"></i>
                    {{ category.name }}
                </li>
            </ul>
        </div>
        <div style="margin-top: 50px">
            <h4 class="mb-3">Most Comments</h4>
            <ul class="top-post-list">
                <li v-for="(blog, index) in mostComments" class="d-flex">
                    <h2>{{ index + 1 }}</h2>
                    <div class="ms-3">
                        <router-link :to="'/blog/' + blog.id">{{ blog.title }}</router-link>
                        <div class="small-text">
                            {{ blog.categories.map(category => category.name).join(', ') }}
                            - {{ blog.created_at | moment('MMM DD, YYYY') }}
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from '@/lib/vue';
import { Component } from 'vue-property-decorator';
import Category from '@/models/category';
import Blog from '@/models/blog';

@Component
export default class Sidebar extends Vue {
    selectedCategory: number[] = [];

    selectCategory(id: number) {
        if (this.selectedCategory.includes(id)) {
            this.$delete(this.selectedCategory, this.selectedCategory.indexOf(id));
        } else {
            this.selectedCategory.push(id);
        }

        this.$emit('search', 'category', this.selectedCategory);
    }

    get categories() {
        return Category.all();
    }

    get mostComments() {
        return this.lodash.sortBy(Blog.all(), blog => blog.comments.length)
                   .reverse()
                   .filter(blog => blog.comments.length > 0);
    }
}
</script>
