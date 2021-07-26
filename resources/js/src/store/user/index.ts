import type { Module } from 'vuex';
import { RootState, User } from '@/types';

export const SET_USER = 'SET_USER';

export const state: User | object = {};

export const user: Module<User, RootState> = {
    state, ...require('./actions'), ...require('./mutations')
};
