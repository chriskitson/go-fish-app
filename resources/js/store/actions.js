import { clientId, clientSecret } from "../config";
import { router } from "../router";
import { handleError, getTokenHeader } from "../utils";

let actions = {
    BOOTSTRAP_DATA_FETCH({ commit }, { queryString, user }) {
        axios
            .get(
                `/api/${
                    user.loggedIn ? "auth/" : ""
                }load?${queryString}&c=${localStorage.getItem("homeToken") ||
                    ""}`,
                getTokenHeader(user)
            )
            .then(res => {
                commit("BOOTSTRAP_DATA", res.data);
            })
            .catch(err => {
                // commit("ERRORS_SET", {
                //     feature: "Get Suppliers",
                //     status: err.response.status,
                //     message: err.message
                // });
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
                `/api/${
                    user.loggedIn ? "auth/" : ""
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
                `/api/${
                    user.loggedIn ? "auth/" : ""
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
                `/api/auth/book`, {
                    url
                },
                getTokenHeader(user)
            )
            .then(res => {
                commit("BOOK", res.data);
            })
            .catch(err => {
                commit("BASKET_ERROR", err.response.data);
            });
    },
    LOGIN({ commit }, { email, password }) {
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
                `/api/auth/basket/${venue_id}/${ticket_id}/${date.getTime()}?qty=${qty}`, {},
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
    }
};
export default actions;