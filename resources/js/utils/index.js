export const getTokenHeader = user => {
    const { loggedIn, access_token, token_type } = user;
    return loggedIn
        ? {
              headers: { Authorization: `${token_type} ${access_token}` }
          }
        : {};
};

export const handleError = err => {
    if (err?.message === "Unauthenticated.") {
        window.location.href = "/login";
    }
};

export const formatCurrency = num => {
    return parseInt(num).toLocaleString("en-GB", {
        style: "currency",
        currency: "GBP"
    });
};

export const formatDateDisplay = date => {
    const fd = new Date(date);
    return fd.toLocaleDateString("en-GB");
};

export const clearErrors = state => {
    state.alerts = [];
    state.venueDetail.tickets = state.venueDetail.tickets.map(t => ({
        ...t,
        error: "",
        success: ""
    }));
    state.basket = state.basket.map(b => ({
        ...b,
        error: ""
    }));
    return state;
};
