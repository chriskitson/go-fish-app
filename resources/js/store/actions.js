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
    VENUE_TICKETS_GET({ commit }, id) {
        return axios
            .get(`/api/venues/tickets/${id}`)
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
    }
};
export default actions;
