export const bindState = (context, state) => {
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
    return state;
};
