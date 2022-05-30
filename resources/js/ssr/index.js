export const bindState = (context, state, client) => {
    if (context.venueDetail) {
        state.venueDetail = {
            ...state.venueDetail,
            ...context.venueDetail,
        };
        if (context.venueDetail.date) {
            const date = new Date(context.venueDetail.date);
            state.venueDetail = {
                ...state.venueDetail,
                date
            };
            state.dateSearch = date;
        }
        if (context.venueDetail.name) {
            state.venueSearch = {
                ...state.venueSearch,
                search: context.venueDetail.name
            };
        }
    }
    if (context.venueSearchResults) {
        state.venueSearchResults = context.venueSearchResults.results;
        state.venueSearch.search = context.venueSearchResults.search;
    }
    if (context.path) {
        state.path = context.path;
    }
    if (context.bookingFee) {
        state.bookingFee = parseFloat(context.bookingFee);
    }
    if (context.dateSearch) {
        state.dateSearch = new Date(context.dateSearch);
    }
    if (context.venueSearch) {
        state.venueSearch = context.venueSearch;
    }
    if (context.manageVenues) {
        state.manageVenues = context.manageVenues;
    }
    if (context.venueCategory && context.venueCategory.length > 0) {
        state.venueCategory = context.venueCategory;
    }
    if (context.venueCategoryDetail) {
        state.venueCategoryDetail = context.venueCategoryDetail;
    }
    if (context.allCategories) {
        state.allCategories = context.allCategories;
    }
    if (context.signupPlace) {
        state.signupForm = {
            ...state.signupForm,
            fisheryName: context.signupPlace.name,
            search: context.signupPlace.name,
            placeId: context.signupPlace.placeId,
            address: context.signupPlace.address
        }
    }
    if (client) {
        state.user = {
            ...state.user,
            loggedIn: localStorage.getItem("access_token") !== null,
            access_token: localStorage.getItem("access_token") !== null ?
                localStorage.getItem("access_token") : "",
            refresh_token: localStorage.getItem("refresh_token") !== null ?
                localStorage.getItem("refresh_token") : "",
            token_type: localStorage.getItem("token_type") !== null ?
                localStorage.getItem("token_type") : "",
            globalAdmin: localStorage.getItem("globalAdmin") !== null ?
                localStorage.getItem("globalAdmin") === "true" : "",
            userType: localStorage.getItem("userType") !== null ?
                localStorage.getItem("userType") : ""
        };
    }

    return state;
};