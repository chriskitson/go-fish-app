import Vue from "vue";
import App from "./HomePage";
import Vuex from "vuex";
import store from "../../store";
import VIcon from "vue-tailwind-icons";

Vue.use(Vuex);
Vue.use(VIcon, { set: "outline" });

Vue.component(
    "header-component",
    require("../../components/layout/HeaderComponent.vue").default
);

Vue.component(
    "location-component",
    require("../../components/location/LocationComponent.vue").default
);

Vue.component(
    "home-component",
    require("../../components/layout/HomeComponent.vue").default
);

Vue.component(
    "top-search-component",
    require("../../components/search/TopSearchComponent.vue").default
);

Vue.component(
    "footer-component",
    require("../../components/layout/FooterComponent.vue").default
);

Vue.component(
    "banner-component",
    require("../../components/presentation/banner/BannerComponent.vue").default
);

Vue.component(
    "venue-list-component",
    require("../../components/presentation/venue/VenueListComponent.vue").default
);

Vue.component(
    "venue-item-component",
    require("../../components/presentation/venue/VenueItemComponent.vue").default
);

Vue.component(
    "category-list-component",
    require("../../components/presentation/category/CategoryListComponent.vue").default
);

Vue.component(
    "category-item-component",
    require("../../components/presentation/category/CategoryItemComponent.vue").default
);

export default new Vue({
    render: h => h(App),
    store
});
