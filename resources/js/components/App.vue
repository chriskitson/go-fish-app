<template>
    <main class="w-full" id="app">
        <header-component></header-component>
        <home-component
            :venues="venues"
            :live="live"
            :userPosition="userPosition"
            @showLocation="showLocationSearch"
        ></home-component>
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
            venues: state => state.venues,
            live: state => state.live,
            userPosition: state => state.userPosition,
            locationSearch: state => state.locationSearch
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
                    this.getData(
                        `?latitude=${latitude}&longitude=${longitude}`
                    );
                },
                error => {
                    this.getData("");
                }
            );
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
                const { geometry: { location }} = this.$store.state.locationSearch.detail;
                localStorage.removeItem("homeToken");
                this.getData(`?latitude=${location.lat()}&longitude=${location.lng()}`);
            }
        }
    }
};
</script>
