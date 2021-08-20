import renderVueComponentToString from "vue-server-renderer/basic";
import app from "./app-main";
import store from "./store";
import { router } from "./router";

// pre-fetched state
if (context) {
    if (context.venueDetail) {
        store.state.venueDetail = {
            ...store.state.venueDetail,
            ...context.venueDetail
        };
    }
}

new Promise((resolve, reject) => {
    router.push(context.path);
    router.onReady(() => {
        const matchedComponents = router.getMatchedComponents();
        if (!matchedComponents.length) {
            return reject({ code: 404 });
        }
        resolve(app);
    }, reject);
})
    .then(app => {
        renderVueComponentToString(app, (err, res) => {
            dispatch(res);
        });
    })
    .catch(err => {
        dispatch(err);
    });
