import app from './detail';
import renderVueComponentToString from 'vue-server-renderer/basic';
import store from '../../store';

// pre-fetched state
if (context) {
    store.state.venueDetail = context.venueDetail.original;
}

renderVueComponentToString(app, (err, html) => {
    if (err) {
        throw new Error(err);
    }
    dispatch(html);
});