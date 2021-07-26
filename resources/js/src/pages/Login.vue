<template>
    <div class="login-container">
        <div class="left-side">
            <h1>Login Page</h1>
            <hr style="width:30px">
            <p>See the beauty of the blogging!</p>
        </div>
        <div class="right-side">
            <div class="card shadow">
                <div class="card-body">
                    <login-form v-if="visibility.login"></login-form>
                    <register-form v-else-if="visibility.register"></register-form>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from '@/lib/vue';
import { Component, Inject, Provide } from 'vue-property-decorator';
import RegisterForm from '@/components/RegisterForm.vue';
import LoginForm from '@/components/LoginForm.vue';

@Component({
    components: { LoginForm, RegisterForm }
})
export default class Login extends Vue {
    @Inject() checkSession;

    visibility = {
        login: true,
        register: false
    };

    async created() {
        if (await this.checkSession()) {
            await this.$router.replace('/home');
        }
    }

    @Provide('show')
    show(key: 'login' | 'register') {
        if (key === 'login') {
            this.visibility.login = true;
            this.visibility.register = false;
        } else if (key === 'register') {
            this.visibility.login = false;
            this.visibility.register = true;
        }
    }
}
</script>
