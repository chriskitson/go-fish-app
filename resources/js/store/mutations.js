import { clearErrors } from "../utils";
import { MESSAGES } from "../config/messages";
import { manageTabs } from "./state";
import { userRegister } from "../utils/klaviyo";
import { searchCountries } from "../config";

let mutations = {
    // Generic
    CLEAR_ERRORS(state) {
        state = clearErrors(state);
    },
    SET_LOADING(state, loading) {
        state.loading = loading;
    },
    // Load user data
    BOOTSTRAP_DATA(state, data) {
        state.venues = data.venues
            ? data.venues.map(v => {
                  const photos = v.photos !== "" ? JSON.parse(v.photos) : [];
                  const venue = {
                      ...v,
                      image:
                          !v.image && photos && photos.length > 0
                              ? photos[0].url
                              : v.image
                  };
                  return venue;
              })
            : [];
        state.userPosition = data.userPosition;
        state.locationSearch = {
            show: false,
            search: "",
            detail: null
        };
        state.live = true;
        state.categories = data.categories;
        state.allCategories = data.allCategories;
        state.stripe = data.stripe;
        localStorage.setItem("homeToken", data.token);
        localStorage.setItem("origin", data.userPosition?.origin);
    },
    USER_DATA(state, data) {
        state.user = {
            ...state.user,
            ...data.user
        };
        localStorage.setItem(
            "globalAdmin",
            data.user.globalAdmin ? "true" : "false"
        );
        localStorage.setItem("userType", data.user.userType);
        const {
            user: { firstName, lastName, email, userType }
        } = state;
        userRegister({
            // klaviyo user track
            firstName,
            lastName,
            email,
            role: userType === 1 ? "Fisher" : "Fishery"
        });
    },
    // User register and login
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
            // state.user = {
            //     loggedIn: false,
            //     access_token: "",
            //     refresh_token: "",
            //     token_type: ""
            // };
            // localStorage.setItem("access_token", null);
            // localStorage.setItem("refresh_token", null);
            // localStorage.setItem("token_type", null);
        }
        state.loading = false;
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
        localStorage.removeItem("globalAdmin");
        localStorage.removeItem("userType");
        state.loading = false;
        window.location.href = "/";
    },
    REGISTER(state, res) {
        const { success, email, errors } = res;
        state.registerForm.errors = [];
        if (success === true) {
            state.loginForm = {
                ...state.loginForm,
                email
            };
            state.registerForm = {
                messages: [],
                errors: [],
                name: "",
                email: "",
                password: "",
                confirm: ""
            };
            state.registerForm.messages = [MESSAGES.LOGIN.Registered];
        } else {
            state.registerForm.errors = Object.values(errors).flat();
        }
        state.loading = false;
    },
    SIGNUP(state, res) {
        const { success, errors, data } = res;
        if (success === true) {
            state.signupForm = {
                messages: [],
                errors: [],
                name: "",
                email: "",
                password: "",
                confirm: "",
                search: "",
                placeId: "",
                address: "",
                confirmed: true
                // stripeUrl: stripe
            };
        } else {
            if (data?.venue_managed) {
                state.signupForm.errors = [MESSAGES.ERRORS.VenueManaged];
            } else if (errors) {
                state.signupForm.errors = Object.values(errors).flat();
            }
        }
        state.loading = false;
    },
    // Location
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
    // Venue tickets
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
        state.loading = false;
        state.dateSearch = date;
    },
    VENUE_TICKET_SET(state, ticket) {
        state.venueDetail = {
            ...state.venueDetail,
            tickets: [
                {
                    ...ticket,
                    error: "",
                    success: ""
                }
            ],
            ticketsLoaded: true
        };
    },
    // Venue Search
    VENUE_SEARCH_SET(state, detail) {
        if (!detail) {
            state.venueSearch = {
                ...state.venueSearch,
                detail: null,
                valid: false
            };
            return;
        }

        // get country (for validation purposes)
        let country = detail.address_components.filter(
            a => a.types.indexOf("country") > -1
        );
        country = country.length > 0 ? country[0].short_name : "";
        state.venueSearch = {
            ...state.venueSearch,
            detail,
            valid: searchCountries.indexOf(country) > -1
        };
    },
    DATE_SET(state, date) {
        state.dateSearch = date;
    },
    VENUE_SEARCH_TYPE_SET(state, type) {
        state.venueSearch.type = type;
    },
    VENUE_SEARCH_RESULTS_SET(state, res) {
        state.venueSearchResults = res.results;
    },
    // Basket
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
        state,
        { success, availability, ticket_id, basket_id, message, bookings }
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
            const stripe = Stripe(window.__STRIPE_PK__, {
                stripeAccount: res.account_id
            });
            stripe.redirectToCheckout({ sessionId: res.session_id });
        }
    },
    // My Tickets
    MY_TICKETS_GET(state, res) {
        state.userTickets = res;
    },
    MY_TICKET_GET(state, res) {
        state.userTicketDetail = res;
    },
    // Manage Venues
    VENUE_DETAILS_UPDATE(state, { success, venue, errors }) {
        state.manageVenueErrorFields = [];
        if (success === true) {
            state.venueDetail = {
                ...state.venueDetail,
                ...venue
            };
        } else {
            state.manageVenueErrorFields = Object.keys(errors);
            if (state.manageVenueErrorFields.length > 0) {
                const firstError = state.manageVenueErrorFields[0];
                if (
                    firstError === "name" ||
                    firstError === "image" ||
                    firstError === "description" ||
                    firstError === "rules"
                ) {
                    state.venueManageTab = manageTabs.DETAILS;
                } else if (firstError === "account") {
                    state.venueManageTab = manageTabs.PAYMENT;
                } else if (
                    firstError === "address" ||
                    firstError === "place_id"
                ) {
                    state.venueManageTab = manageTabs.LOCATION;
                }
            }
        }
        state.loading = false;
    },
    VENUE_MANAGE_TAB(state, tab) {
        state.venueManageTab = tab;
    },
    VENUE_DETAILS_CREATE(state, { success, venue, errors }) {
        state.manageVenueErrorFields = [];
        if (success === true) {
            state.venueDetail = {
                ...state.venueDetail,
                ...venue
            };
        } else {
            state.manageVenueErrorFields = Object.keys(errors);
        }
        state.loading = false;
    },
    VENUE_DELETE(state, { id }) {
        const findVenue = state.manageVenues.findIndex(v => v.id == id);
        if (findVenue > -1) {
            state.manageVenues.splice(findVenue, 1);
        }
        state.loading = false;
    },
    VENUE_TICKET_ADD(state) {
        state.venueDetail = {
            ...state.venueDetail,
            tickets: [
                ...state.venueDetail.tickets,
                {
                    id: 0,
                    name: "",
                    description: "",
                    cost: "",
                    daily_limit: 10
                }
            ]
        };
        state.manageVenueNewTicket = true;
    },
    VENUE_TICKET_SAVE(state, ticket) {
        state.manageVenueErrorFields = [];
        if (ticket.response) {
            state.manageVenueErrorFields = Object.keys(ticket.response);
        } else {
            // remove empty ticket
            const findEmptyTicket = state.venueDetail.tickets.findIndex(
                t => t.id === 0
            );
            if (findEmptyTicket > -1) {
                state.venueDetail.tickets.splice(findEmptyTicket, 1);
            }
            // find update or add new ticket
            const findTicket = state.venueDetail.tickets.findIndex(
                t => t.id === ticket.id
            );
            if (findTicket > -1) {
                state.venueDetail.tickets[findTicket] = ticket;
            } else {
                state.venueDetail.tickets.push(ticket);
            }
            state.manageVenueNewTicket = false;
        }
        state.loading = false;
    },
    VENUE_TICKET_DELETE(state, { id }) {
        const findTicket = state.venueDetail.tickets.findIndex(t => t.id == id);
        if (findTicket > -1) {
            state.venueDetail.tickets.splice(findTicket, 1);
        }
        state.loading = false;
    },
    VENUE_IMAGE_UPLOAD(state, { venue_id, image_url }) {
        state.venueDetail = {
            ...state.venueDetail,
            image: image_url
        };
        state.loading = false;
    },
    VENUE_CLOSED_START(state, date) {
        state.venueManageClosed.start = date;
    },
    VENUE_CLOSED_END(state, date) {
        state.venueManageClosed.end = date;
    },
    VENUE_CLOSED_ADD(state, { start_date, end_date, id }) {
        state.venueDetail.closed.push({
            start_date,
            end_date,
            id
        });
        state.loading = false;
    },
    VENUE_CLOSED_DELETE(state, id) {
        const findDate = state.venueDetail.closed.findIndex(t => t.id == id);
        if (findDate > -1) {
            state.venueDetail.closed.splice(findDate, 1);
        }
        state.loading = false;
    },
    VENUES_NEAR(state, { venues, town }) {
        state.venueCategory = venues;
        state.userPosition = {
            ...state.userPosition,
            town
        };
        state.loading = false;
    },
    VENUE_BOOKINGS_GET(state, res) {
        state.venueBookings = res;
    },
    MY_VENUE_SUBSCRIPTION_GET(state, res) {
        state.venueSignUpDetail = res;
    },
    SUBSCRIPTION_CREATE(state, { success, session_id }) {
        if (success) {
            // redirect to stripe session
            const stripe = Stripe(window.__STRIPE_PK__);
            stripe.redirectToCheckout({ sessionId: session_id });
            state.signupForm.messages = [MESSAGES.LOGIN.Registered];
        }
    },
    SUBSCRIPTION_CANCEL(state, { success }) {
        if (success) {
            state.venueDetail = {
                ...state.venueDetail,
                subscription: {
                    ...state.venueDetail.subscription,
                    confirmed: false,
                    amount: null,
                    type: ""
                }
            };
        }
        state.loading = false;
    },
    VENUES_ADMIN(state, res) {
        state.manageVenues = res;
        state.loading = false;
    },
    STRIPE_ACCOUNT_CREATE(state, { success, account, accountLink, venue_id }) {
        if (success) {
            state.venueDetail = {
                ...state.venueDetail,
                account,
                accountLink
            };
            if (accountLink && accountLink !== "") {
                window.location.href = accountLink; // redirect to stripe
            } else {
                state.loading = false;
            }
        } else {
            state.loading = false;
        }
    },
    CATEGORIES_ADMIN(state, res) {
        state.manageCategories = res;
        state.loading = false;
    },
    CATEGORY_MANAGE_SET(state, res) {
        state.manageCategory = {
            ...state.manageCategory,
            ...res
        };
        state.loading = false;
    },
    CATEGORY_IMAGE_UPLOAD(state, { image_url }) {
        state.manageCategory = {
            ...state.manageCategory,
            image: image_url
        };
        state.loading = false;
    },
    CATEGORY_IMAGE_DELETE(state) {
        state.manageCategory = {
            ...state.manageCategory,
            image: ""
        };
        state.loading = false;
    }
};
export default mutations;
