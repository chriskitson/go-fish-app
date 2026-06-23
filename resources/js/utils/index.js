import { format } from "date-fns";

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
    if (
        err &&
        (err.message === "Unauthenticated." || err.response.status === 401)
    ) {
        window.location.href = "/login";
    }
};

export const currencySymbol = (currency = "GBP") => {
    const symbols = { GBP: "£", EUR: "€", USD: "$" };
    return symbols[currency] || currency;
};

export const formatCurrency = (num, currency = "GBP") => {
    return parseFloat(num).toLocaleString("en-GB", {
        style: "currency",
        currency: currency
    });
};

export const poundsToPennies = pounds => {
    return Math.round(pounds * 100);
};

export const formatLongDateDisplay = date => {
    const fd = new Date(date);
    return fd.toLocaleDateString("en-GB", {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric"
    });
};

export const formatDateDisplay = date => {
    return format(new Date(date), "dd/MM/yyyy");
};

export const formatDateTimeDisplay = date => {
    return format(new Date(date), "dd/MM/yyyy HH:mm");
};

export const formatDateDisplayFromTime = time => {
    const fd = new Date(time * 1000);
    return fd.toLocaleDateString("en-GB");
};

export const formatDateAPI = date => {
    const fd = new Date(date);
    return fd.toISOString().slice(0, 10);
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

export const groupBy = (arr, criteria) => {
    const newObj = arr.reduce(function(acc, currentValue) {
        if (!acc[currentValue[criteria]]) {
            acc[currentValue[criteria]] = [];
        }
        acc[currentValue[criteria]].push(currentValue);
        return acc;
    }, {});
    return newObj;
};

export const padNumber = (number, len) => {
    return String(number).padStart(len, "0");
};

export const contentTitle = route => {
    switch (route) {
        case "about":
            return "About GoFish";
        case "contact":
            return "Contact us";
        case "privacy":
            return "Privacy Policy";
        case "terms":
            return "Terms and Conditions";
        case "privacy":
            return "Privacy Policy";
        case "faq":
            return "Frequently Asked Questions";
        case "complaints":
            return "Complaints Policy";
        default:
            return "GoFish";
    }
};

export const getDay = d => {
    const days = ["Sun", "Mon", "Tue", "Wed", "Thur", "Fri", "Sat"];
    return days[d];
};
