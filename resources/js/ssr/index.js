export const bindState = (context, state, client) => {
    if (context.venueDetail) {
        state.venueDetail = {
            ...state.venueDetail,
            ...context.venueDetail
        };
    }
    if (context.venueSearchResults) {
        state.venueSearchResults = context.venueSearchResults.results;
        state.venueSearch.search = context.venueSearchResults.search;
    }
    if (context.path) {
        state.path = context.path;
    }
    if (client) {
        state.user = {
            ...state.user,
            loggedIn: localStorage.getItem("access_token") !== null,
            access_token:
                localStorage.getItem("access_token") !== null
                    ? localStorage.getItem("access_token")
                    : "",
            refresh_token:
                localStorage.getItem("refresh_token") !== null
                    ? localStorage.getItem("refresh_token")
                    : "",
            token_type:
                localStorage.getItem("token_type") !== null
                    ? localStorage.getItem("token_type")
                    : ""
        };
    }

    return state;
};
