import type { ActionTree } from 'vuex';

import { SET_USER } from '@/store/user';
import type { RootState, User } from '@/types';


export const actions: ActionTree<User, RootState> = {
    setUser({ commit }, status: User): void {
        commit(SET_USER, status);
    }
};
