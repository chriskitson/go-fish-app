import state from "./state";

let mutations = {
    EXAMPLE(state, data) {
        state.venues = data;
    },
    LIVE(state, data) {
        state.live = data;
    },
    BOOTSTRAP_DATA(state, data) {
        state.venues = data.venues;
        state.userPosition = data.userPosition;
        state.live = true;
    },
    LOCATION_SEARCH_SHOW(state, show) {
        state.locationSearch = {
            ...state.locationSearch,
            show
        };
    },
};

export default mutations;
