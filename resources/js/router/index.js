import Vue from "vue";
import VueRouter from 'vue-router';

import Home from '../pages/home/HomePage';
import Detail from '../pages/detail/DetailPage';
import Search from '../pages/search/SearchPage';
import Login from '../pages/login/LoginPage';
import SignUp from '../pages/signup/SignUpPage';
import Basket from '../pages/basket/BasketPage';
import Confirm from '../pages/confirm/ConfirmPage';
import SignUpConfirm from '../pages/signup-confirm/SignUpConfirmPage';
import MyTickets from '../pages/my-tickets/MyTicketsPage';
import ManageVenues from '../pages/manage-venues/ManageVenuesPage';
import ManageVenue from '../pages/manage-venue/ManageVenuePage';
import Category from '../pages/category/CategoryPage';
import Bookings from '../pages/bookings/BookingsPage';
import Content from '../pages/content/ContentPage';

Vue.use(VueRouter);

export const routes = [
    { path: '/', component: Home, name: 'Home' },
    { path: '/login', component: Login, name: 'Login' },
    { path: '/signup', component: SignUp, name: 'SignUp' },
    { path: '/signup/confirm', component: SignUpConfirm, name: 'Signup Confirm' },
    { path: '/confirm/:id', component: Confirm, name: 'Confirm' },
    { path: '/basket', component: Basket, name: 'Basket' },
    { path: '/venue/:id', component: Detail, name: 'Venue' },
    { path: '/venue/:id/:date', component: Detail, name: 'Venue By Date' },
    { path: '/search/:date/:location', component: Search, name: 'Search' },
    { path: '/tickets', component: MyTickets, name: 'My Tickets' },
    { path: '/manage-venues', component: ManageVenues, name: 'Manage Venues' },
    { path: '/manage-venues/:id', component: ManageVenue, name: 'Manage Venue' },
    { path: '/add-venue', component: ManageVenue, name: 'Add Venue' },
    { path: '/category/:id', component: Category, name: 'Category' },
    { path: '/bookings', component: Bookings, name: 'Bookings' },
    { path: '/about', component: Content, name: 'About us' },
    { path: '/contact', component: Content, name: 'Contact us' },
    { path: '/privacy', component: Content, name: 'Privacy Policy' },
    { path: '/terms', component: Content, name: 'Terms and Conditions' },
    { path: '/privacy', component: Content, name: 'Privacy' },
    { path: '/faq', component: Content, name: 'FAQs' },
    { path: '/complaints', component: Content, name: 'Complaints' },
];

export const router = new VueRouter({
    mode: 'history',
    routes
});