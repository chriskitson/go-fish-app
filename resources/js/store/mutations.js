let mutations = {
    EXAMPLE(state, data) {
        state.venues = data;
    },
    LIVE(state, data) {
        state.live = data;
    },
    BOOTSTRAP_DATA(state, data) {
        state.venues = data.venues;
        state.live = true;
    },
    USER_POSITION(state, data) {
        state.userPosition = data;
    }
};

export default mutations;
