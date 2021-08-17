import app from './app';
import renderVueComponentToString from 'vue-server-renderer/basic';
const axios = require('axios');

renderVueComponentToString(app, (err, html) => {
    if (err) {
        throw new Error(err);
    }
    dispatch(html);
});