import { clearErrors } from "../utils";
import { MESSAGES } from "../config/messages";

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
    DATE_SET(state, date) {
        state.dateSearch = date;
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
    VENUE_TICKETS_SET(state, { tickets, date }) {
        state.venueDetail = {
            ...state.venueDetail,
            tickets: tickets.map(t => ({
                ...t,
                error: "",
                success: ""
            })),
            ticketsLoaded: true,
            date
        };
        // state.dateSearch = date;
    },
    VENUE_TICKET_SET(state, ticket) {
        state.venueDetail = {
            ...state.venueDetail,
            tickets: [{
                ...ticket,
                error: "",
                success: ""
            }],
            ticketsLoaded: true
        };
    },
    VENUE_SEARCH_RESULTS_SET(state, res) {
        state.venueSearchResults = res.results;
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
            // state.loginForm.messages = ["You have been successfully logged in"];
            state.user = {
                loggedIn: true,
                access_token,
                refresh_token,
                token_type
            };
            localStorage.setItem("access_token", access_token);
            localStorage.setItem("refresh_token", refresh_token);
            localStorage.setItem("token_type", token_type);
            if (localStorage.getItem("referrer") !== null) {
                const ref = localStorage.getItem("referrer");
                localStorage.removeItem("referrer");
                window.location.href = ref;
            } else {
                window.location.href = "/";
            }
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
    LOGOUT(state, res) {
        state.user = {
            loggedIn: false,
            access_token: "",
            refresh_token: "",
            token_type: ""
        };
        localStorage.removeItem("access_token");
        localStorage.removeItem("refresh_token");
        localStorage.removeItem("token_type");
    },
    REGISTER(state, res) {
        const { success, email, errors } = res;
        state.registerForm.errors = [];
        if (success === true) {
            state.loginForm = {
                ...state.loginForm,
                email
            };
            state.registerForm.messages = [MESSAGES.LOGIN.Registered];
        } else {
            state.registerForm.errors = Object.values(errors).flat();
        }
    },
    BASKET_GET(state, res) {
        state.basket = res.map(b => ({
            ...b,
            error: ""
        }));
    },
    BASKET_ADD(state, { success, basket, ticket_id }) {
        if (success) {
            const i = state.venueDetail.tickets.findIndex(
                t => t.id === ticket_id
            );
            if (i > -1) {
                state.venueDetail.tickets[i].success = MESSAGES.BASKET.Added;
            }
            state.basket = basket.map(b => ({
                ...b,
                error: ""
            }));
        }
    },
    BASKET_REMOVE(state, id) {
        const i = state.basket.findIndex(b => b.basket_id === id);
        if (i > -1) {
            state.basket.splice(i, 1);
        }
    },
    BASKET_QTY(state, { direction, id }) {
        const i = state.basket.findIndex(b => b.basket_id === id);
        if (direction === "up") {
            state.basket[i].basket_qty += 1;
        }
        if (direction === "down") {
            state.basket[i].basket_qty -= 1;
        }
    },
    BASKET_ERROR(
        state, { success, availability, ticket_id, basket_id, message, bookings }
    ) {
        if (!success && !!message && state.alerts.indexOf(message) === -1) {
            state.alerts.push(message);
        } else if (!success && !availability) {
            if (!!ticket_id) {
                const i = state.venueDetail.tickets.findIndex(
                    t => t.id === ticket_id
                );
                if (i > -1) {
                    state.venueDetail.tickets[i].error =
                        MESSAGES.BASKET.NoQuantity;
                }
            }
            if (!!basket_id) {
                const i = state.basket.findIndex(
                    b => b.basket_id === basket_id
                );
                if (i > -1) {
                    state.basket[i].error = MESSAGES.CHECKOUT.NoQuantity;
                }
            }
            if (bookings && bookings.length > 0) {
                const failed = bookings.filter(b => !b.success);
                failed.forEach(booking => {
                    const i = state.basket.findIndex(
                        b => b.basket_id == booking.basket_id
                    );
                    console.log(state.basket);
                    console.log(booking.basket_id);
                    if (i > -1) {
                        state.basket[i].error = MESSAGES.CHECKOUT.NoQuantity;
                    }
                });
            }
        }
    },
    BOOK(state, res) {
        if (res.success === true) {
            state = clearErrors(state);
            // redirect to stripe payment page
            stripe.redirectToCheckout({ sessionId: res.session_id });
        }
    },
    CLEAR_ERRORS(state) {
        state = clearErrors(state);
    },
    MY_TICKETS_GET(state, res) {
        state.userTickets = res;
    }
};

export default mutations;