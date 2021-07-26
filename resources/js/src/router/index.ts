import type { RouteConfig } from 'vue-router';
import Login from '@/pages/Login.vue';
import Home from '@/pages/Home.vue';
import Admin from '@/pages/Admin.vue';
import BlogPost from '@/pages/BlogPost.vue';
import BlogPage from '@/pages/BlogPage.vue';
import Me from '@/pages/Me.vue';

const routes: RouteConfig[] = [
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'home',
        path: '/home',
        component: Home
    },
    {
        name: 'me',
        path: '/me',
        component: Me
    },
    {
        name: 'post',
        path: '/post',
        component: BlogPost
    },
    {
        name: 'blog-edit',
        path: '/blog/:id/edit',
        component: BlogPost
    },
    {
        name: 'blog-page',
        path: '/blog/:id',
        component: BlogPage
    },
    {
        name: 'admin',
        path: '/admin',
        component: Admin
    },
    {
        path: '*',
        beforeEnter: () => {
            window.location.href = '/home';
        }
    }
];

export default routes;
