export const getTokenHeader = (user, contentType = "application/json") => {
    const { loggedIn, access_token, token_type } = user;
    return loggedIn
        ? {
              headers: {
                  Authorization: `${token_type} ${access_token}`,
                  "Content-Type": contentType
              }
          }
        : { "Content-Type": contentType };
};

export const handleError = err => {
    if (err && err.message === "Unauthenticated.") {
        window.location.href = "/login";
    }
};

export const formatCurrency = num => {
    return parseInt(num).toLocaleString("en-GB", {
        style: "currency",
        currency: "GBP"
    });
};

export const formatLongDateDisplay = date => {
    const fd = new Date(date);
    return fd.toLocaleDateString("en-GB", {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};

export const formatDateDisplay = date => {
    const fd = new Date(date);
    return "bananas";
    return fd.toLocaleDateString("en-GB");
};

export const formatDateTimeDisplay = date => {
    const fd = new Date(date);
    return `${fd.toLocaleDateString("en-GB")} ${fd.toLocaleTimeString(
        "en-GB"
    )}`;
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
