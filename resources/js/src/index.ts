import { Vue } from 'vue-property-decorator';
import VueRouter from 'vue-router';
import routes from '@/router';
import VueLodash from 'vue-lodash';
import VueAxios from 'vue-axios';
import VueCookies from 'vue-cookies';
import VueMoment from 'vue-moment';
import lodash from 'lodash';
import axios from 'axios';
import Vuex, { Store } from 'vuex';
import storeOptions from '@/store';
import Vuelidate from 'vuelidate';

export default class Application {
    private router?: VueRouter;

    bindPlugins() {
        Vue.use(VueRouter);
        Vue.use(VueLodash, { lodash });
        Vue.use(VueAxios, axios);
        Vue.use(VueMoment);
        Vue.use(VueCookies);
        Vue.use(Vuex);
        Vue.use(Vuelidate);

        return this;
    }

    setRoutes() {
        this.router = new VueRouter({
            routes: routes,
            linkActiveClass: 'active',
            mode: 'history'
        });

        this.router.afterEach((to) => {
            document.body.id = to.name || '';
        });

        return this;
    }

    render() {
        return new Vue({
            router: this.router,
            store: new Store(storeOptions),
            render: h => h(require('./pages/App').default)
        }).$mount('#app');
    }
}
