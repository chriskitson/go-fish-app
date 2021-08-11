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
        show: true,
        search: ''
    }
};

export default state;
