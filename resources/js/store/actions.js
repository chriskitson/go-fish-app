let actions = {
    EXAMPLE({ commit }, data) {
        commit("FORM_SECTION", data);
    },
    LIVE({ commit }, live) {
        commit("LIVE", live);
    },
    BOOTSTRAP_DATA_FETCH({ commit }, data) {
        axios
            .get(
                `/api/load`
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
    }
};
export default actions;
