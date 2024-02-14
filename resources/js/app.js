import './bootstrap';
import { createApp } from 'vue';
import App from './layouts/App.vue'
import router from './router.js';
import store from './store/index.js'
import axios from 'axios'
import 'vuetify/styles';
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';

const vuetify = createVuetify({
    components,
    directives,
    icons: {
        defaultSet: 'mdi',
    },
});
const app = createApp(App);

app.config.globalProperties.$axios = axios
app.use(router);
app.use(vuetify);
app.use(store)
app.mount('#app');

// createApp(App)
//     .use(router)
//     .use(axios)
//     .use(vuetify)
//     .mount('#app');