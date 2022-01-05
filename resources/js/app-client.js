import app from "./app-main";
import store from "./store";
import { bindState } from "./ssr";






// import client only
import "./client-bootstrap";
import 'vue2-datepicker/index.css';

if (window.__INITIAL_STATE__) {
    const context = JSON.parse(window.__INITIAL_STATE__);
    store.replaceState(bindState(context, store.state, true));
}

app.$mount("#app");
