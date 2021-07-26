import { Model } from '@vuex-orm/core';
import { AttrField, OrmModel, PrimaryKey } from 'vuex-orm-decorators';
import type { Config } from '@vuex-orm/plugin-axios';
import Category from '@/models/category';
import { Comment, User } from '@/types';

@OrmModel('blog')
export default class Blog extends Model {
    @PrimaryKey()
    @AttrField() id!: number;
    @AttrField() user_id!: number;
    @AttrField() title!: string;
    @AttrField() content!: string;
    @AttrField() image!: string;
    @AttrField() user!: User;
    @AttrField() comments!: Comment[];
    @AttrField() categories!: Category[];
    @AttrField() created_at!: string;

    static apiConfig: Config = {
        baseURL: '/api/blogs'
    };

    static async fetch(params: object = {}) {
        await this.api().get('', params);
    }

    static async fetchById(id: number, params: object = {}, force: boolean = false) {
        if (!this.find(id) || force) {
            await this.api().get('' + id, params);
        }
    }
}
