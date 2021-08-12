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
        search: '',
        detail: null
    }
};

export default state;
