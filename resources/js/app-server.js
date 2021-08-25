import renderVueComponentToString from "vue-server-renderer/basic";
import app from "./app-main";
import store from "./store";
import { router } from "./router";
import { bindState } from "./ssr";

if (context) {  // pre-fetched state
    store.replaceState(bindState(context, store.state, false));
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
