import Vue from "vue";
import VueRouter from 'vue-router';

import Home from '../pages/home/HomeComponent';
import Detail from '../pages/detail/DetailComponent';
import Search from '../pages/search/SearchComponent';

Vue.use(VueRouter);

export const routes = [
    { path: '/', component: Home, name: 'Home' },
    { path: '/venue/:id', component: Detail, name: 'Detail' },
    { path: '/search/:date/:location', component: Search, name: 'Search' },
];

export const router = new VueRouter({
  mode: 'history',
  routes
});