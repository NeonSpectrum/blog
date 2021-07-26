import type { MutationTree } from 'vuex';

import { SET_USER } from '@/store/user';
import { User } from '@/types';

export const mutations: MutationTree<User> = {
    [SET_USER](state: User, payload: User) {
        Object.assign(state, payload);
    }
};
