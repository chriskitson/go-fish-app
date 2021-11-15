import Vue from "vue";
import VueRouter from 'vue-router';

import Home from '../pages/home/HomePage';
import Detail from '../pages/detail/DetailPage';
import Search from '../pages/search/SearchPage';
import Login from '../pages/login/LoginPage';
import Basket from '../pages/basket/BasketPage';
import Confirm from '../pages/confirm/ConfirmPage';
import MyTickets from '../pages/my-tickets/MyTicketsPage';
import ManageVenues from '../pages/manage-venues/ManageVenuesPage';
import ManageVenue from '../pages/manage-venue/ManageVenuePage';
import Category from '../pages/category/CategoryPage';

Vue.use(VueRouter);

export const routes = [
    { path: '/', component: Home, name: 'Home' },
    { path: '/login', component: Login, name: 'Login' },
    { path: '/confirm', component: Confirm, name: 'Confirm' },
    { path: '/basket', component: Basket, name: 'Basket' },
    { path: '/venue/:id', component: Detail, name: 'Detail' },
    { path: '/search/:date/:location', component: Search, name: 'Search' },
    { path: '/tickets', component: MyTickets, name: 'My Tickets' },
    { path: '/manage-venues', component: ManageVenues, name: 'Manage Venues' },
    { path: '/manage-venues/:id', component: ManageVenue, name: 'Manage Venue' },
    { path: '/add-venue', component: ManageVenue, name: 'Add Venue' },
    { path: '/category/:id', component: Category, name: 'Category' },
];

export const router = new VueRouter({
    mode: 'history',
    routes
});