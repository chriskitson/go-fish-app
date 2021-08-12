let mutations = {
    BOOTSTRAP_DATA(state, data) {
        state.venues = data.venues;
        state.userPosition = data.userPosition;
        state.locationSearch = {
            show: false,
            search: '',
            detail: null
        };
        state.live = true;
        localStorage.setItem('homeToken', data.token);
    },
    LOCATION_SEARCH_SHOW(state, show) {
        state.locationSearch = {
            ...state.locationSearch,
            show
        };
    },
    LOCATION_SEARCH_SET(state, detail) {
        state.locationSearch = {
            ...state.locationSearch,
            detail
        };
    }
};

export default mutations;
