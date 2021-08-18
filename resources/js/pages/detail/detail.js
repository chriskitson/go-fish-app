import Vue from "vue";
import App from "./DetailPage";
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
    require("../../components/layout/HeaderComponent.vue").default
);

Vue.component(
    "detail-component",
    require("../../components/layout/DetailComponent.vue").default
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
    "ticket-list-component",
    require("../../components/presentation/ticket/TicketListComponent.vue").default
);

Vue.component(
    "ticket-item-component",
    require("../../components/presentation/ticket/TicketItemComponent.vue").default
);

export default new Vue({
    render: h => h(App),
    store
});
