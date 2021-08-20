let state = {
    live: false,
    venues: [],
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
    dateSearch: new Date().getTime(),
    venueDetail: {
        id: 0,
        name: "",
        address: "",
        description: "",
        tickets: []
    },
    venueSearchResults: []
};

export default state;
