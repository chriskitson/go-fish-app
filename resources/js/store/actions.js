import { clientId, clientSecret } from "../config";
import { router } from "../router";
import { handleError, getTokenHeader } from "../utils";

let actions = {
    BOOTSTRAP_DATA_FETCH({ commit }, { queryString, user }) {
        axios
            .get(
                `/api/${user.loggedIn ? "auth/" : ""
                }load?${queryString}&c=${localStorage.getItem("homeToken") ||
                ""}`,
                getTokenHeader(user)
            )
            .then(res => {
                commit("BOOTSTRAP_DATA", res.data);
            })
            .catch(err => {
                commit("LOGOUT", {
                    success: true
                });
            });
    },
    USER_DATA_FETCH({ commit }, { user }) {
        axios
            .get(
                `/api/${user.loggedIn ? "auth/" : ""
                }user`,
                getTokenHeader(user)
            )
            .then(res => {
                commit("USER_DATA", res.data);
            })
            .catch(err => {
                commit("LOGOUT", {
                    success: true
                });
            });
    },
    VENUES_NEAR({ commit }, { queryString, user }) {
        axios
            .get(
                `/api/${user.loggedIn ? "auth/" : ""
                }venues/near?${queryString}&o=${localStorage.getItem("origin") ||
                ""}`,
                getTokenHeader(user)
            )
            .then(res => {
                commit("VENUES_NEAR", res.data);
            })
            .catch(err => {
                handleError(err.response.data.message);
            });
    },
    LOCATION_SEARCH_SHOW({ commit }, show) {
        commit("LOCATION_SEARCH_SHOW", show);
    },
    LOCATION_SEARCH_SET({ commit }, detail) {
        commit("LOCATION_SEARCH_SET", detail);
    },
    VENUE_SEARCH_SET({ commit }, detail) {
        commit("VENUE_SEARCH_SET", detail);
    },
    DATE_SET({ commit }, date) {
        commit("DATE_SET", date);
    },
    VENUE_TICKETS_GET({ commit }, { id, date, user }) {
        return axios
            .get(
                `/api/${user.loggedIn ? "auth/" : ""
                }venues/tickets/${id}?d=${date.getTime()}`,
                getTokenHeader(user)
            )
            .then(res => {
                commit("VENUE_TICKETS_SET", {
                    tickets: res.data,
                    date
                });
            })
            .catch(err => {
                handleError(err.response.data.message);
            });
    },
    VENUE_TICKET_GET({ commit }, { venue_id, id, date, user }) {
        return axios
            .get(
                `/api/${user.loggedIn ? "auth/" : ""
                }venues/ticket/${venue_id}/${id}?d=${date.getTime()}`,
                getTokenHeader(user)
            )
            .then(res => {
                commit("VENUE_TICKET_SET", res.data);
            })
            .catch(err => {
                handleError(err.response.data.message);
            });
    },
    VENUE_SEARCH_RESULTS_GET({ commit }, { date, location }) {
        return axios
            .get(`/api/search/${date.getTime()}/${location}`)
            .then(res => {
                commit("VENUE_SEARCH_RESULTS_SET", res.data);
                router.push(`/search/${date}/${location}`);
            })
            .catch(err => {
                handleError(err.response.data.message);
            });
    },
    BOOK({ commit }, { user, url }) {
        return axios
            .post(
                `/api/auth/book`,
                {
                    url
                },
                getTokenHeader(user)
            )
            .then(res => {
                commit("BOOK", res.data);
            })
            .catch(err => {
                commit("BASKET_ERROR", {
                    success: false,
                    message: 'BasketError'
                });
            });
    },
    LOGIN({ commit }, { email, password }) {
        commit("SET_LOADING", true);
        return axios
            .post(`/oauth/token`, {
                username: email,
                password,
                grant_type: "password",
                client_id: clientId,
                client_secret: clientSecret
            })
            .then(res => {
                commit("LOGIN", {
                    success: true,
                    ...res.data
                });
            })
            .catch(err => {
                commit("LOGIN", {
                    success: false,
                    errors: [err.response.data.message]
                });
            });
    },
    LOGOUT({ commit }, user) {
        commit("SET_LOADING", true);
        return axios
            .get(`/api/auth/logout`, getTokenHeader(user))
            .then(res => {
                commit("LOGOUT", {
                    success: true,
                    ...res.data
                });
            })
            .catch(err => {
                commit("LOGOUT", {
                    success: false,
                    errors: [err.response.data.message]
                });
            });
    },
    REGISTER({ commit }, { name, email, password, confirm }) {
        commit("SET_LOADING", true);
        return axios
            .post(`/api/register`, {
                name,
                email,
                password,
                password_confirmation: confirm
            })
            .then(res => {
               commit("REGISTER", res.data);
            })
            .catch(err => {
                commit("REGISTER", {
                    success: false,
                    errors: [err.response.data.message]
                });
            });
    },
    SIGNUP({ commit }, { fisheryName, placeId, address, name, email, password, confirm, subscription }) {
        commit("SET_LOADING", true);
        return axios
            .post(`/api/signup`, {
                fisheryName,
                placeId,
                address,
                name,
                email,
                password,
                password_confirmation: confirm,
                subscription
            })
            .then(res => {
                commit("SIGNUP", res.data);
            })
            .catch(err => {
                commit("SIGNUP", {
                    success: false,
                    errors: [ err.response?.data?.message ],
                    data: err.response?.data
                });
            });
    },
    BASKET_GET({ commit }, user) {
        return axios
            .get(`/api/auth/basket`, getTokenHeader(user))
            .then(res => {
                commit("BASKET_GET", res.data);
            })
            .catch(err => {
                handleError(err.response.data.message);
            });
    },
    BASKET_ADD({ commit }, { ticket_id, venue_id, date, user, qty }) {
        commit("CLEAR_ERRORS");
        return axios
            .post(
                `/api/auth/basket/${venue_id}/${ticket_id}/${date.getTime()}?qty=${qty}`,
                {},
                getTokenHeader(user)
            )
            .then(res => {
                commit("BASKET_ADD", res.data);
            })
            .catch(err => {
                commit("BASKET_ERROR", err.response.data);
            });
    },
    BASKET_QTY({ commit }, { direction, id, user }) {
        return axios
            .get(`/api/auth/basket/${id}/${direction}`, getTokenHeader(user))
            .then(res => {
                if (res.data.success === true) {
                    commit("BASKET_QTY", {
                        id,
                        direction
                    });
                }
            })
            .catch(err => {
                commit("BASKET_ERROR", err.response.data);
            });
    },
    BASKET_REMOVE({ commit }, { id, user }) {
        return axios
            .delete(`/api/auth/basket/${id}`, getTokenHeader(user))
            .then(res => {
                if (res.data.success === true) {
                    commit("BASKET_REMOVE", id);
                }
            })
            .catch(err => {
                // TODO
            });
    },
    MY_TICKETS_GET({ commit }, { user }) {
        return axios
            .get(`/api/auth/bookings/user`, getTokenHeader(user))
            .then(res => {
                commit("MY_TICKETS_GET", res.data);
            })
            .catch(err => {
                handleError(err.response.data.message);
            });
    },
    MY_TICKET_GET({ commit }, { user, session }) {
        return axios
            .get(`/api/auth/booking/${session}`, getTokenHeader(user))
            .then(res => {
                commit("MY_TICKET_GET", res.data);
            })
            .catch(err => {
                handleError(err.response.data.message);
            });
    },
    VENUE_TICKET_ADD({ commit }) {
        commit("VENUE_TICKET_ADD");
    },
    VENUE_DETAILS_CREATE({ commit }, { venue, user }) {
        commit("SET_LOADING", true);
        return axios
            .post(`/api/auth/venues`, venue, getTokenHeader(user))
            .then(res => {
                commit("VENUE_DETAILS_CREATE", {
                    success: true,
                    venue: res.data
                });
            })
            .catch(err => {
                commit("VENUE_DETAILS_CREATE", {
                    success: false,
                    errors: err.response.data
                });
            });
    },
    VENUE_DETAILS_UPDATE({ commit }, { venue, user }) {
        commit("SET_LOADING", true);
        return axios
            .put(
                `/api/auth/venues/${venue.id}/details`,
                venue,
                getTokenHeader(user)
            )
            .then(res => {
                commit("VENUE_DETAILS_UPDATE", {
                    success: true,
                    venue: res.data
                });
            })
            .catch(err => {
                commit("VENUE_DETAILS_UPDATE", {
                    success: false,
                    errors: err.response.data
                });
            });
    },
    VENUE_DELETE({ commit }, { id, user }) {
        commit("SET_LOADING", true);
        return axios
            .delete(`/api/auth/venues/${id}`, getTokenHeader(user))
            .then(res => {
                commit("VENUE_DELETE", res.data);
            })
            .catch(err => {
                commit("SET_LOADING", false);
                handleError(err.response.data.message);
            });
    },
    VENUE_TICKET_SAVE({ commit }, { venue_id, ticket, user }) {
        commit("SET_LOADING", true);
        if (venue_id > 0) {
            return axios
                .put(
                    `/api/auth/venues/${venue_id}/ticket`,
                    ticket,
                    getTokenHeader(user)
                )
                .then(res => {
                    commit("VENUE_TICKET_SAVE", res.data);
                })
                .catch(err => {
                    commit("SET_LOADING", false);
                    handleError(err.response.data.message);
                });
        }
    },
    VENUE_TICKET_DELETE({ commit }, { venue_id, id, user }) {
        commit("SET_LOADING", true);
        return axios
            .delete(
                `/api/auth/venues/${venue_id}/ticket/${id}`,
                getTokenHeader(user)
            )
            .then(res => {
                commit("VENUE_TICKET_DELETE", res.data);
            })
            .catch(err => {
                commit("SET_LOADING", false);
                handleError(err.response.data.message);
            });
    },
    VENUE_IMAGE_UPLOAD({ commit }, { venue_id, image, user }) {
        commit("SET_LOADING", true);

        let formData = new FormData();
        formData.append("image", image);

        return axios
            .post(
                `/api/auth/venues/${venue_id}/image`,
                formData,
                getTokenHeader(user, "multipart/form-data")
            )
            .then(res => {
                commit("VENUE_IMAGE_UPLOAD", {
                    ...res.data,
                    venue_id
                });
            })
            .catch(err => {
                commit("SET_LOADING", false);
                handleError(err.response.data);
            });
    },
    VENUE_IMAGE_DELETE({ commit }, { venue_id, user }) {
        commit("SET_LOADING", true);
        return axios
            .delete(`/api/auth/venues/${venue_id}/image`, getTokenHeader(user))
            .then(res => {
                commit("VENUE_IMAGE_UPLOAD", {
                    image_url: "",
                    venue_id
                });
            })
            .catch(err => {
                commit("SET_LOADING", false);
                handleError(err.response.data.message);
            });
    },
    VENUE_MANAGE_TAB({ commit }, tab) {
        commit("VENUE_MANAGE_TAB", tab);
    },
    VENUE_CLOSED_START({ commit }, date) {
        commit("VENUE_CLOSED_START", date);
    },
    VENUE_CLOSED_END({ commit }, date) {
        commit("VENUE_CLOSED_END", date);
    },
    VENUE_CLOSED_ADD({ commit }, { start, end, user, venue_id }) {
        commit("SET_LOADING", true);
        return axios
            .post(
                `/api/auth/venues/${venue_id}/closed`,
                {
                    start,
                    end
                },
                getTokenHeader(user)
            )
            .then(res => {
                commit("VENUE_CLOSED_ADD", res.data);
            })
            .catch(err => {
                commit("SET_LOADING", false);
                handleError(err.response.data.message);
            });
    },
    VENUE_CLOSED_DELETE({ commit }, { id, user, venue_id }) {
        commit("SET_LOADING", true);
        return axios
            .delete(
                `/api/auth/venues/${venue_id}/closed/${id}`,
                getTokenHeader(user)
            )
            .then(res => {
                commit("VENUE_CLOSED_DELETE", id);
            })
            .catch(err => {
                commit("SET_LOADING", false);
                handleError(err.response.data.message);
            });
    },
    VENUE_BOOKINGS_GET({ commit }, { user, showPast }) {
        return axios
            .get(`/api/auth/bookings/venue?past=${showPast}`, getTokenHeader(user))
            .then(res => {
                commit("VENUE_BOOKINGS_GET", res.data);
            })
            .catch(err => {
                handleError(err.response.data.message);
            });
    },
    CLEAR_CACHE({ commit }, user) {
        commit("SET_LOADING", true);
        return axios
            .get(
                `/api/auth/cache/bust`,
                getTokenHeader(user)
            )
            .then(res => {
                console.log('cache cleared');
                commit("SET_LOADING", false);
            })
            .catch(err => {
                commit("SET_LOADING", false);
                handleError(err.response.data.message);
            });
    },
    MY_VENUE_SUBSCRIPTION_GET({ commit }, { session }) {
        return axios
            .get(`/api/signup/${session}`)
            .then(res => {
                commit("MY_VENUE_SUBSCRIPTION_GET", res.data);
            })
            .catch(err => {
                handleError(err.response.data.message);
            });
    },
    SUBSCRIPTION_CREATE({ commit }, { venue_id, user }) {
        commit("SET_LOADING", true);
        return axios
            .get(
                `/api/auth/venues/${venue_id}/subscription`,
                getTokenHeader(user)
            )
            .then(res => {
                commit("SUBSCRIPTION_CREATE", res.data);
            })
            .catch(err => {
                commit("SET_LOADING", false);
                handleError(err.response.data.message);
            });
    },
    SUBSCRIPTION_CANCEL({ commit }, { venue_id, user }) {
        commit("SET_LOADING", true);
        return axios
            .delete(
                `/api/auth/venues/${venue_id}/subscription`,
                getTokenHeader(user)
            )
            .then(res => {
                commit("SUBSCRIPTION_CANCEL", res.data);
            })
            .catch(err => {
                commit("SET_LOADING", false);
                handleError(err.response.data.message);
            });
    },
    VENUES_ADMIN({ commit }, { venue_id, user }) {
        commit("SET_LOADING", true);
        return axios
            .get(
                `/api/auth/venues/admin`,
                getTokenHeader(user)
            )
            .then(res => {
                commit("VENUES_ADMIN", res.data);
            })
            .catch(err => {
                commit("SET_LOADING", false);
                handleError(err.response.data.message);
            });
    },
};
export default actions;
