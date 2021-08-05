<template>
    <div>
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <form @submit.prevent="postBlog">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input v-model="$v.title.$model" type="text" id="title" class="form-control">
                            <div v-show="$v.title.$dirty && !$v.title.required"
                                 class="invalid-feedback"
                            >
                                Please choose a title.
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <label for="content">Content</label>
                            <textarea v-model="$v.content.$model" id="content" class="form-control" rows="5"></textarea>
                            <div v-show="$v.content.$dirty && !$v.content.required"
                                 class="invalid-feedback"
                            >
                                Please choose a content.
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <label class="mb-2">Category</label>
                            <div v-for="category in categoryList" class="form-check">
                                <label class="form-check-label">
                                    <input v-model="$v.categories.$model" type="checkbox"
                                           :value="category.id"
                                    >
                                    {{ category.name }}
                                </label>
                            </div>
                            <div v-show="$v.categories.$dirty && !$v.categories.required"
                                 class="invalid-feedback"
                            >
                                Please choose a category.
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <label for="image" class="form-label">Blog Image</label>
                            <input @change="uploadFile" class="form-control" type="file" id="image" accept="image/*">
                            <div v-show="$v.image.$dirty && !$v.image.required"
                                 class="invalid-feedback"
                            >
                                Please choose an image.
                            </div>
                        </div>
                        <img v-if="imageSrc" :src="imageSrc" alt="" width="300">
                        <br>
                        <div v-if="!id" class="float-end">
                            <button class="btn btn-primary mt-2">Post</button>
                        </div>
                        <div v-else class="float-end">
                            <button @click="$router.back()" type="button" v-if="id" class="btn btn-secondary mt-2">
                                Cancel
                            </button>
                            <button v-if="id" class="btn btn-primary mt-2">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from '@/lib/vue';
import { Component } from 'vue-property-decorator';
import Navbar from '@/components/Navbar.vue';
import Blog from '@/models/blog';
import Category from '@/models/category';
import { Validate, Validations } from 'vuelidate-property-decorators';
import { required, requiredIf } from 'vuelidate/lib/validators';

@Component({
    components: { Navbar }
})
export default class BlogPost extends Vue {
    id!: number;
    imageSrc: string = '';
    title: string = '';
    content: string = '';
    image: File | string | null = null;
    categories: number[] = [];

    @Validations()
    validations() {
        return {
            title: { required },
            content: { required },
            image: { required: requiredIf(() => !this.id) },
            categories: { required }
        };
    }

    async created() {
        this.id = +this.$route.params.id;

        if (this.id) {
            await Blog.fetchById(this.id);

            this.title = this.blog?.title || '';
            this.content = this.blog?.content || '';
            this.categories = this.blog?.categories.map(category => category.id) || [];
            this.imageSrc = this.blog?.image || '';
        }
    }

    get blog() {
        return Blog.find(this.id);
    }

    get categoryList() {
        return Category.all();
    }

    async postBlog() {
        this.$v.$touch();

        if (this.$v.$invalid) return;

        let response = !this.id ? await this.$http.post('/api/blogs', {
            title: this.title,
            content: this.content,
            categories: this.categories,
            image: this.image
        }) : await this.$http.put('/api/blogs/' + this.id, {
            title: this.title,
            content: this.content,
            categories: this.categories,
            image: this.image || undefined
        });

        alert(response.data.message);

        this.id ? await Blog.fetchById(this.id, {}, true) : await Blog.fetch();
        await this.$router.push(!this.id ? '/home' : '/blog/' + this.id);
    }

    uploadFile(e: Event) {
        let files = (e.target as HTMLInputElement)?.files || [];

        if (files.length === 0) return;
        this.image = files[0];
        this.imageSrc = URL.createObjectURL(this.image);
    }
}
</script>
