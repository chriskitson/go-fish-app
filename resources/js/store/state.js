const today = new Date();
const tomorrow = new Date(today.getTime() + 24 * 60 * 60 * 1000);

export const manageTabs = {
    DETAILS: 1,
    HOURS: 2,
    PAYMENT: 3,
    LOCATION: 4,
    TICKETS: 5
};

export const userType = {
    NONE: 0,
    FISHER: 1,
    FISHERY: 2
};

let state = {
    live: false,
    loading: false,
    path: "",
    bookingFee: 0,
    venues: [],
    categories: [],
    allCategories: [],
    alerts: [],
    user: {
        loggedIn: false,
        access_token: "",
        refresh_token: "",
        token_type: "",
        userType: userType.NONE,
        globalAdmin: false,
        email: "",
        firstName: "",
        lastName: "",
        venue: {
            id: 0,
            name: ""
        }
    },
    basket: [],
    loginForm: {
        messages: [],
        errors: [],
        email: "",
        password: ""
    },
    registerForm: { // fisherman
        messages: [],
        errors: [],
        name: "",
        email: "",
        password: "",
        confirm: ""
    },
    signupForm: {   // fishery
        messages: [],
        errors: [],
        name: "",
        email: "",
        password: "",
        confirm: "",
        search: "",
        placeId: "",
        address: "",
        fisheryName: "",
        confirmed: false,
        stripeUrl: "",
        subscription: "lite"
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
        phone: "",
        description: "",
        tickets: [],
        closed: [],
        ticketsLoaded: false,
        date: tomorrow,
        account: "",
        days: {
            sunday: false,
            monday: false,
            tuesday: false,
            wednesday: false,
            thursday: false,
            friday: false,
            saturday: false
        },
        subscription: {
            confirmed: false,
            reference: '',
            type: '',
            amount: null
        }
    },
    venueSearchResults: [],
    userTickets: [],
    userTicketDetail: {},
    manageVenues: [],
    manageVenueNewTicket: false,
    manageVenueErrorFields: [],
    venueCategory: [],
    venueCategoryDetail: {},
    venueManageClosed: {
        start: today,
        end: tomorrow
    },
    venueManageTab: manageTabs.DETAILS,
    venueBookings: [],
    venueSignUpDetail: {}
};

export default state;