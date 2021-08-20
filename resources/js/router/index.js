import Vue from "vue";
import VueRouter from 'vue-router';

import Home from '../pages/home/HomeComponent';
import Detail from '../pages/detail/DetailComponent';

Vue.use(VueRouter);

export const routes = [
    { path: '/', component: Home, name: 'Home' },
    { path: '/venue/:id', component: Detail, name: 'Detail' },
];

export const router = new VueRouter({
  mode: 'history',
  routes
});