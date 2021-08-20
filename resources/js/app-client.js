import "./client-bootstrap";
import app from "./app-main";
import store from "./store";

// hydrate client with pre-fetched state
if (window.__INITIAL_STATE__) {
    const context = JSON.parse(window.__INITIAL_STATE__);
    if (context.venueDetail) {
        store.state.venueDetail = {
            ...store.state.venueDetail,
            ...context.venueDetail
        };
    }
}

app.$mount("#app");
