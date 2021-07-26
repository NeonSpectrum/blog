import { Component, Vue } from 'vue-property-decorator';
import * as utils from './utils';

@Component
export default class extends Vue {
    get $utils() {
        return utils;
    }

    get $user() {
        return this.$store.state.user;
    }

    $setToken(value: string) {
        this.$cookies.set('AUTH_TOKEN', value, 60 * 60);
    }

    $getToken() {
        return this.$cookies.get('AUTH_TOKEN');
    }

    $checkToken() {
        if (!this.$getToken() && this.$route.name !== 'login') {
            this.$router.replace('/login').then();
            return false;
        }

        return true;
    }
}
