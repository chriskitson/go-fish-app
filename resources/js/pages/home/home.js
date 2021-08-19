import Vue from "vue";
import App from "./HomePage";
import Vuex from "vuex";
import store from "../../store";
import VIcon from "vue-tailwind-icons";
import VueFilterDateFormat from "@vuejs-community/vue-filter-date-format";
import VueFilterDateParse from "@vuejs-community/vue-filter-date-parse";

Vue.use(Vuex);
Vue.use(VIcon, { set: "outline" });
Vue.use(VueFilterDateFormat);
Vue.use(VueFilterDateParse);

Vue.component(
    "header-component",
    require("../../components/layout/header/HeaderComponent.vue").default
);

Vue.component(
    "footer-component",
    require("../../components/layout/footer/FooterComponent.vue").default
);

Vue.component(
    "home-component",
    require("../../components/layout/home/HomeComponent.vue").default
);

Vue.component(
    "location-component",
    require("../../components/location/LocationComponent.vue").default
);

Vue.component(
    "top-search-component",
    require("../../components/search/TopSearchComponent.vue").default
);

Vue.component(
    "banner-component",
    require("../../components/banner/BannerComponent.vue").default
);

Vue.component(
    "venue-list-component",
    require("../../components/venue/VenueListComponent.vue").default
);

Vue.component(
    "venue-item-component",
    require("../../components/venue/VenueItemComponent.vue").default
);

Vue.component(
    "category-list-component",
    require("../../components/category/CategoryListComponent.vue").default
);

Vue.component(
    "category-item-component",
    require("../../components/category/CategoryItemComponent.vue").default
);

export default new Vue({
    render: h => h(App),
    store
});
