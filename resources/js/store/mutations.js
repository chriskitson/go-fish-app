let mutations = {
    BOOTSTRAP_DATA(state, data) {
        state.venues = data.venues;
        state.userPosition = data.userPosition;
        state.locationSearch = {
            show: false,
            search: "",
            detail: null
        };
        state.live = true;
        localStorage.setItem("homeToken", data.token);
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
        };
    },
    VENUE_TICKET_SET(state, ticket) {
        state.venueDetail = {
            ...state.venueDetail,
            tickets: [ ticket ],
            ticketsLoaded: true
        }
    },
    VENUE_SEARCH_RESULTS_SET(state, res) {
        state.venueSearchResults = res.results;
    },
    TICKET_BOOK(state, res) {
        if (res.success === true) {
            const { ticket_id, availability, status, user } = res;
            const ticket = state.venueDetail.tickets.findIndex(
                t => t.id === ticket_id
            );
            state.venueDetail.tickets[ticket].status = status;
            state.venueDetail.tickets[ticket].availability = availability;
            state.venueDetail.tickets[ticket].user = user;
        }
    },
    LOGIN(state, res) {
        const {
            success,
            errors,
            access_token,
            refresh_token,
            token_type
        } = res;
        state.loginForm.messages = [];
        state.loginForm.errors = [];
        if (success === true) {
            state.loginForm.messages = ["You have been successfully logged in"];
            state.user = {
                loggedIn: true,
                access_token,
                refresh_token,
                token_type
            };
            localStorage.setItem("access_token", access_token);
            localStorage.setItem("refresh_token", refresh_token);
            localStorage.setItem("token_type", token_type);
        } else {
            state.loginForm.errors = errors;
            state.user = {
                loggedIn: false,
                access_token: "",
                refresh_token: "",
                token_type: ""
            };
        }
    },
    REGISTER(state, res) {
        const { success, email, errors } = res;
        state.registerForm.errors = [];
        if (success === true) {
            state.loginForm = {
                ...state.loginForm,
                email
            };
            state.registerForm.messages = [
                "Thank you for registering, you may now log in"
            ];
        } else {
            state.registerForm.errors = Object.values(errors).flat();
        }
    }
};

export default mutations;
