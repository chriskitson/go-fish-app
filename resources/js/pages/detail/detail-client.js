import "../../client-bootstrap";
import app from "./detail";
import store from '../../store';

// hydrate client with pre-fetched state
if (window.__INITIAL_STATE__) {
  const context = JSON.parse(window.__INITIAL_STATE__);
  store.state.venueDetail = context.venueDetail.original;
}

app.$mount("#app");
