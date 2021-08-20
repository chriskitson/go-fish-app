<template>
    <main class="w-full" id="app">
        <header-component></header-component>
        <div class="w-full max-w-5xl mx-auto">
            <top-search-component
                :venueSearch="venueSearch"
                :date="dateSearch"
                @set="setLocation"
                @search="searchVenues"
            ></top-search-component>
        </div>
        <router-view></router-view>
        <footer-component></footer-component>
        <location-component
            v-if="locationSearch.show"
            :locationSearch="locationSearch"
            @show="showLocationSearch"
            @set="setLocation"
            @update="updateLocation"
        ></location-component>
    </main>
</template>
<script>
import { mapState } from "vuex";
export default {
    computed: {
        ...mapState({
            locationSearch: state => state.locationSearch,
            venueSearch: state => state.venueSearch,
            dateSearch: state => state.dateSearch
        })
    },
    mounted() {
        this.getUserPosition();
    },
    methods: {
        getUserPosition() {
            navigator.geolocation.getCurrentPosition(
                position => {
                    const {
                        coords: { latitude, longitude }
                    } = position;
                    this.getLocationData(
                        `latitude=${latitude}&longitude=${longitude}`
                    );
                },
                error => {
                    this.getLocationData("");
                }
            );
        },
        getLocationData(q) {
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
                this.getLocationData(
                    `latitude=${location.lat()}&longitude=${location.lng()}`
                );
            }
        },
        setLocation(detail) {
            this.$store.dispatch("LOCATION_SEARCH_SET", detail);
        },
        searchVenues() {
            const { dateSearch, venueSearch } = this.$store.state;
            if (dateSearch && venueSearch.detail) {
                console.log({
                    date: dateSearch,
                    location: venueSearch.detail.place_id
                });
            }
        }
    }
};
</script>
