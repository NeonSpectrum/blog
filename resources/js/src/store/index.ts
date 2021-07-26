import type { StoreOptions } from 'vuex';
import VuexORM from '@vuex-orm/core';
import VuexORMAxios from '@vuex-orm/plugin-axios';

import axios from 'axios';
import { user } from '@/store/user';
import { ORMDatabase } from 'vuex-orm-decorators';

VuexORM.use(VuexORMAxios, {
    axios,
    dataTransformer: response => response?.data || []
});

const storeOptions: StoreOptions<any> = {
    plugins: [ORMDatabase.install()],
    modules: { user }
};

export default storeOptions;
