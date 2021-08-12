let actions = {
    BOOTSTRAP_DATA_FETCH({ commit }, queryString) {
        axios
            .get(
                `/api/load${queryString}&c=${localStorage.getItem("homeToken") || ""}`
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
    }
};
export default actions;
