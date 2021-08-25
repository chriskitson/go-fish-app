import Vue from "vue";
import VueRouter from 'vue-router';

import Home from '../pages/home/HomePage';
import Detail from '../pages/detail/DetailPage';
import Search from '../pages/search/SearchPage';
import Login from '../pages/login/LoginPage';

Vue.use(VueRouter);

export const routes = [
    { path: '/', component: Home, name: 'Home' },
    { path: '/login', component: Login, name: 'Login' },
    { path: '/venue/:id', component: Detail, name: 'Detail' },
    { path: '/search/:date/:location', component: Search, name: 'Search' },
];

export const router = new VueRouter({
  mode: 'history',
  routes
});