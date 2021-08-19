<script>
import { mapState } from "vuex";

export default {
    computed: {
        ...mapState({
            venues: state => state.venues,
            live: state => state.live,
            userPosition: state => state.userPosition,
            locationSearch: state => state.locationSearch,
            venueSearch: state => state.venueSearch,
            dateSearch: state => state.dateSearch,
            venueDetail: state => state.venueDetail
        })
    },
    methods: {
        getUserPosition() {
            navigator.geolocation.getCurrentPosition(
                position => {
                    const {
                        coords: { latitude, longitude }
                    } = position;
                    this.getData(`latitude=${latitude}&longitude=${longitude}`);
                },
                error => {
                    this.getData("");
                }
            );
        },
        getVenueTickets(id, date) {
            return this.$store.dispatch("VENUE_TICKETS_GET", {
                id,
                date
            });
        },
        getData(q) {
            this.$store.dispatch("BOOTSTRAP_DATA_FETCH", q);
        },
        showLocationSearch(show) {
            this.$store.dispatch("LOCATION_SEARCH_SHOW", show);
        },
        setLocation(detail) {
            this.$store.dispatch("LOCATION_SEARCH_SET", detail);
        },
        updateLocation() {
            if (this.$store.state.locationSearch.detail) {
                const {
                    geometry: { location }
                } = this.$store.state.locationSearch.detail;
                localStorage.removeItem("homeToken");
                this.getData(
                    `latitude=${location.lat()}&longitude=${location.lng()}`
                );
            }
        },
        setVenueLocation(detail) {
            this.$store.dispatch("VENUE_SEARCH_SET", detail);
        },
        searchVenues() {
            const { dateSearch, venueSearch } = this.$store.state;
            if (dateSearch && venueSearch.detail) {
                console.log({
                    date: dateSearch,
                    location: venueSearch.detail.place_id
                });
            }
        },
        setDate() {
            console.log("setd ate");
        }
    }
};
</script>