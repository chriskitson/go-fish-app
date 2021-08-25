<template>
    <main :class="`w-full ${bgColor}`" id="app">
        <header-component :user="user"></header-component>
        <div class="w-full max-w-5xl mx-auto" v-if="showSearch">
            <top-search-component
                :venueSearch="venueSearch"
                :date="dateSearch"
                @set="setVenueLocation"
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
            dateSearch: state => state.dateSearch,
            bgColor: state => state.path === 'login' ? 'bg-grey-light' : 'bg-white',
            showSearch: state => state.path !== 'login',
            user: state => state.user
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
        setVenueLocation(detail) {
            this.$store.dispatch("VENUE_SEARCH_SET", detail);
        },
        setLocation(detail) {
            this.$store.dispatch("LOCATION_SEARCH_SET", detail);
        },
        searchVenues() {
            const { dateSearch, venueSearch } = this.$store.state;
            if (dateSearch && venueSearch.detail) {
                window.location.href = `/search/${dateSearch}/${venueSearch.detail.place_id}`;
            }
        }
    }
};
</script>
