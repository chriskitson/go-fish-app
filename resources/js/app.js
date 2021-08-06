import Vue from "vue";
import App from "./components/App";
import Vuex from "vuex";

Vue.use(Vuex);

Vue.component(
    "header-component",
    require("./components/presentation/Header.vue").default
);

Vue.component(
    "footer-component",
    require("./components/presentation/Footer.vue").default
);

export default new Vue({
    render: h => h(App)
});
