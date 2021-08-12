let mutations = {
    BOOTSTRAP_DATA(state, data) {
        console.log(data.token);
        state.venues = data.venues;
        state.userPosition = data.userPosition;
        localStorage.setItem('homeToken', data.token);
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
