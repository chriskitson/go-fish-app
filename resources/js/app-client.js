import Vue from "vue";
import app from "./app-main";
import store from "./store";
import { bindState } from "./ssr";
import "./client-bootstrap";

if (window.__INITIAL_STATE__) {
    const context = JSON.parse(window.__INITIAL_STATE__);
    store.replaceState(bindState(context, store.state, true));
}

app.$mount("#app");
