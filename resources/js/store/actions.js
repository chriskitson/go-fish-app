import { clientId, clientSecret } from '../config';
import { router } from '../router';

let actions = {
    BOOTSTRAP_DATA_FETCH({ commit }, queryString) {
        axios
            .get(
                `/api/load?${queryString}&c=${localStorage.getItem(
                    "homeToken"
                ) || ""}`
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
    VENUE_TICKETS_GET({ commit }, { id, date }) {
        return axios
            .get(`/api/venues/tickets/${id}?d=${date}`)
            .then(res => {
                commit("VENUE_TICKETS_SET", res.data);
            })
            .catch(err => {
                // commit("ERRORS_SET", {
                //     feature: "Get Suppliers",
                //     status: err.response.status,
                //     message: err.message
                // });
            });
    },
    VENUE_SEARCH_RESULTS_GET({ commit }, { date, location }) {
        return axios
            .get(`/api/search/${date}/${location}`)
            .then(res => {
                commit("VENUE_SEARCH_RESULTS_SET", res.data);
                router.push(`/search/${date}/${location}`);
            })
            .catch(err => {
                // commit("ERRORS_SET", {
                //     feature: "Get Suppliers",
                //     status: err.response.status,
                //     message: err.message
                // });
            });
    },
    TICKET_BOOK({ commit }, { ticket_id, venue_id, date }) {
        return axios
            .post(`/api/book/${venue_id}/${ticket_id}/${date}`)
            .then(res => {
                commit("TICKET_BOOK", res.data);
            })
            .catch(err => {
                // commit("ERRORS_SET", {
                //     feature: "Get Suppliers",
                //     status: err.response.status,
                //     message: err.message
                // });
            });
    },
    LOGIN({ commit }, { email, password }) {
        return axios
            .post(`/oauth/token`, {
                username: email,
                password,
                grant_type: 'password',
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
                    errors: [ err.response.data.message ]
                });
            });
    },
    REGISTER({ commit }, { name, email, password, confirm}) {
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
                    errors: [ err.response.data.message ]
                });
            });
    },
};
export default actions;
