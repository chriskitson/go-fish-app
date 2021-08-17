import Vue from "vue";
import App from "./DetailPage";
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

export default new Vue({
    render: h => h(App),
    store
});
