let actions = {
    EXAMPLE({ commit }, data) {
        commit("FORM_SECTION", data);
    },
    LIVE({ commit }, live) {
        commit("LIVE", live);
    },
    // EXAMPLE_CALL({ commit }, data: any) {
    //     if (data && data.name && data.name !== "") {
    //         commit("SUPPLIER_SEARCH_LOADING", true);
    //         commit("ERRORS_CLEAR");
    //         axios
    //             .get(
    //                 `/api/company/search?name=${data.name}&type=${data.type}&country=${data.country}&postcode=${data.postcode}`
    //             )
    //             .then(res => {
    //                 commit("SUPPLIER_SEARCH", res.data);
    //             })
    //             .catch(err => {
    //                 commit("ERRORS_SET", {
    //                     feature: "Get Suppliers",
    //                     status: err.response.status,
    //                     message: err.message
    //                 });
    //             });
    //     } else {
    //         commit("SUPPLIER_SEARCH", []);
    //     }
    // }
};
export default actions;
