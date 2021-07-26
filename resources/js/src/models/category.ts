import { Model } from '@vuex-orm/core';
import { AttrField, OrmModel, PrimaryKey } from 'vuex-orm-decorators';
import type { Config } from '@vuex-orm/plugin-axios';

@OrmModel('category')
export default class Category extends Model {
    @PrimaryKey()
    @AttrField() id!: number;
    @AttrField() name!: string;

    static apiConfig: Config = {
        baseURL: '/api/categories'
    };

    static async fetch(params: object = {}) {
        await this.api().get('', params);
    }
}
