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
    TICKET_BOOK({ commit }, { ticket_id, venue_id }) {
        return axios
            .post(`/api/book/${venue_id}/${ticket_id}`)
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
};
export default actions;
