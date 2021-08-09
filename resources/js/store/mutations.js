let mutations = {
    EXAMPLE(state, data) {
        state.venues = data;
    },
    LIVE(state, data) {
        state.live = data;
    }
};

export default mutations;
