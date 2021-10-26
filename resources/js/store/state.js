const today = new Date();
const tomorrow = new Date(today.getTime() + 24 * 60 * 60 * 1000);

let state = {
    live: false,
    loading: false,
    path: "",
    bookingFee: 0,
    venues: [],
    alerts: [],
    user: {
        loggedIn: false,
        access_token: "",
        refresh_token: "",
        token_type: "",
        userType: 0,
        globalAdmin: false
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
    dateSearch: tomorrow,
    venueDetail: {
        id: 0,
        name: "",
        address: "",
        description: "",
        tickets: [],
        ticketsLoaded: false,
        date: tomorrow
    },
    venueSearchResults: [],
    userTickets: [],
    manageVenues: [],
    manageVenueNewTicket: false,
    manageVenueErrorFields: []
};

export default state;