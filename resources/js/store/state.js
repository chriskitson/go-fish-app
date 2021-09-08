let state = {
    live: false,
    path: "",
    bookingFee: 0,
    venues: [],
    alerts: [],
    user: {
        loggedIn: false,
        access_token: "",
        refresh_token: "",
        token_type: ""
    },
    basket: [],
    loginForm: {
        messages: [],
        errors: [],
        email: "",
        password: ""
    },
    registerForm: {
        messages: [],
        errors: [],
        name: "",
        email: "",
        password: "",
        confirm: ""
    },
    userPosition: {
        error: "",
        latitude: null,
        longitude: null,
        town: ""
    },
    locationSearch: {
        show: false,
        search: "",
        detail: null
    },
    venueSearch: {
        search: "",
        detail: null
    },
    dateSearch: new Date(),
    venueDetail: {
        id: 0,
        name: "",
        address: "",
        description: "",
        tickets: [],
        ticketsLoaded: false
    },
    venueSearchResults: []
};

export default state;
