// import 'bootstrap';
import 'reflect-metadata';
import './bootstrap';
import 'datatables.net-bs5';
import '@fortawesome/fontawesome-free/js/all';

import Application from './src';

new Application().bindPlugins()
                 .setRoutes()
                 .render();
