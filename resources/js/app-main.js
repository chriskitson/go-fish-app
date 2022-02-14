import Vue from "vue";
import Vuex from "vuex";
import VIcon from "vue-tailwind-icons";
import VueFilterDateFormat from "@vuejs-community/vue-filter-date-format";
import VueFilterDateParse from "@vuejs-community/vue-filter-date-parse";


import { router } from "./router";
import store from "./store";
import App from "./pages/app/App";

Vue.use(Vuex);
Vue.use(VIcon, { set: "outline" });
Vue.use(VueFilterDateFormat);
Vue.use(VueFilterDateParse);

Vue.component(
    "header-component",
    require("./components/layout/header/HeaderComponent.vue").default
);

Vue.component(
    "footer-component",
    require("./components/layout/footer/FooterComponent.vue").default
);

Vue.component(
    "login-component",
    require("./components/login/LoginComponent.vue").default
);

Vue.component(
    "register-component",
    require("./components/login/RegisterComponent.vue").default
);

Vue.component(
    "location-component",
    require("./components/location/LocationComponent.vue").default
);

Vue.component(
    "alert-component",
    require("./components/shared/AlertComponent.vue").default
);

Vue.component(
    "rating-component",
    require("./components/shared/RatingComponent.vue").default
);

Vue.component(
    "page-spinner-component",
    require("./components/shared/PageSpinnerComponent.vue").default
);

Vue.component(
    "spinner-component",
    require("./components/shared/SpinnerComponent.vue").default
);

Vue.component(
    "status-component",
    require("./components/shared/StatusComponent.vue").default
);

Vue.component(
    "date-navigation-component",
    require("./components/shared/DateNavigationComponent.vue").default
);

Vue.component(
    "modal-component",
    require("./components/shared/ModalComponent.vue").default
);

Vue.component(
    "quantity-selector-component",
    require("./components/shared/QuantitySelectorComponent.vue").default
);

Vue.component(
    "top-search-component",
    require("./components/search/TopSearchComponent.vue").default
);

Vue.component(
    "home-banner-component",
    require("./components/shared/HomeBannerComponent.vue").default
);

Vue.component(
    "venue-list-component",
    require("./components/venue/VenueListComponent.vue").default
);

Vue.component(
    "venue-item-component",
    require("./components/venue/VenueItemComponent.vue").default
);

Vue.component(
    "category-list-component",
    require("./components/category/CategoryListComponent.vue").default
);

Vue.component(
    "category-item-component",
    require("./components/category/CategoryItemComponent.vue").default
);

Vue.component(
    "photos-component",
    require("./components/photos/PhotosComponent.vue").default
);

Vue.component(
    "reviews-component",
    require("./components/reviews/ReviewsComponent.vue").default
);

Vue.component(
    "banner-component",
    require("./components/shared/BannerComponent.vue").default
);

Vue.component(
    "ticket-list-component",
    require("./components/ticket/TicketListComponent.vue").default
);

Vue.component(
    "ticket-item-component",
    require("./components/ticket/TicketItemComponent.vue").default
);

Vue.component(
    "user-ticket-list-component",
    require("./components/user-ticket/UserTicketListComponent.vue").default
);

Vue.component(
    "user-ticket-item-component",
    require("./components/user-ticket/UserTicketItemComponent.vue").default
);

Vue.component(
    "basket-list-component",
    require("./components/basket/BasketListComponent.vue").default
);

Vue.component(
    "basket-item-component",
    require("./components/basket/BasketItemComponent.vue").default
);

Vue.component(
    "search-result-list-component",
    require("./components/search/SearchResultListComponent.vue").default
);

Vue.component(
    "search-result-item-component",
    require("./components/search/SearchResultItemComponent.vue").default
);

Vue.component(
    "manage-tabs-component",
    require("./components/manage/ManageTabsComponent.vue").default
);

Vue.component(
    "manage-details-component",
    require("./components/manage/ManageDetailsComponent.vue").default
);

Vue.component(
    "manage-opening-hours-component",
    require("./components/manage/ManageOpeningHoursComponent.vue").default
);

Vue.component(
    "manage-payment-component",
    require("./components/manage/ManagePaymentComponent.vue").default
);

Vue.component(
    "manage-location-component",
    require("./components/manage/ManageLocationComponent.vue").default
);

Vue.component(
    "manage-tickets-component",
    require("./components/manage/ManageTicketsComponent.vue").default
);

Vue.component(
    "venue-booking-list-component",
    require("./components/venue-booking/VenueBookingListComponent.vue").default
);

Vue.component(
    "venue-booking-item-component",
    require("./components/venue-booking/VenueBookingItemComponent.vue").default
);

export default new Vue({
    render: h => h(App),
    store,
    router
});