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
    },
    VENUE_SEARCH_SET(state, detail) {
        state.venueSearch = {
            ...state.venueSearch,
            detail
        };
    },
    VENUE_TICKETS_SET(state, tickets) {
        state.venueDetail = {
            ...state.venueDetail,
            tickets,
            ticketsLoaded: true
        }
    },
    VENUE_SEARCH_RESULTS_SET(state, res) {
        state.venueSearchResults = res.results;
    },
    TICKET_BOOK(state, res) {
        if (res.success === true) {
            const { ticket_id, availability, status, user } = res;
            const ticket = state.venueDetail.tickets.findIndex(t => t.id === ticket_id);
            state.venueDetail.tickets[ticket].status = status;
            state.venueDetail.tickets[ticket].availability = availability;
            state.venueDetail.tickets[ticket].user = user;
        }
    }
};

export default mutations;
