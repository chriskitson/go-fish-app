let actions = {
    BOOTSTRAP_DATA_FETCH({ commit }, queryString) {
        axios
            .get(
                `/api/load${queryString}`
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
    USER_POSITION({ commit }, data) {
        commit("USER_POSITION", data);
    }
};
export default actions;
