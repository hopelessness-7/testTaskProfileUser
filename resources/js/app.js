import { createApp } from 'vue';
import App from './App.vue';
import { createRouter, createWebHistory } from 'vue-router';
import { Quasar, QCard, QCardSection, QBtn, QInput, QAvatar, QBadge, QSeparator, QList, QItem, QRadio, QForm, QDialog } from 'quasar';
import quasarUserOptions from './quasar-user-options';

import 'quasar/dist/quasar.css';

import Login from './components/Login.vue';
import Register from './components/Register.vue';
import Profile from './components/Profile.vue';

const routes = [
    { path: '/login', component: Login },
    { path: '/register', component: Register },
    { path: '/profile', component: Profile }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

const app = createApp(App);
app.use(router);
app.use(Quasar, {
    components: {
        QCard,
        QCardSection,
        QBtn,
        QInput,
        QAvatar,
        QBadge,
        QSeparator,
        QList,
        QItem,
        QRadio,
        QForm,
        QDialog
    },
    ...quasarUserOptions
});
app.mount('#app');
