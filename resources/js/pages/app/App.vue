<template>
    <main :class="`w-full ${bgColor}`" id="app">
        <header-component
            :user="user"
            :live="live"
            :basketCount="basketCount"
            :basketTotal="basketTotal"
            @logout="logout"
        ></header-component>
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
import { formatCurrency } from "../../utils";
export default {
    computed: {
        ...mapState({
            locationSearch: state => state.locationSearch,
            venueSearch: state => state.venueSearch,
            dateSearch: state => state.dateSearch,
            bgColor: state =>
                state.path === "login" ? "bg-grey-light" : "bg-white",
            showSearch: state => state.path !== "login",
            user: state => state.user,
            live: state => state.live,
            basket: state => state.basket,
            basketCount: state =>
                state.basket.map(b => b.basket_qty).reduce((a, b) => a + b, 0),
            basketTotal: state =>
                formatCurrency(
                    state.basket
                        .map(b => b.basket_qty * b.ticket_cost)
                        .reduce((a, b) => a + b, 0)
                )
        })
    },
    mounted() {
        this.getUserPosition();
        this.getBasket();
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
        getBasket() {
            this.$store.dispatch("BASKET_GET", this.user);
        },
        getLocationData(q) {
            this.$store.dispatch("BOOTSTRAP_DATA_FETCH", q);
        },
        showLocationSearch(show) {
            this.$store.dispatch("LOCATION_SEARCH_SHOW", show);
        },
        updateLocation() {
            if (this.locationSearch.detail) {
                const {
                    geometry: { location }
                } = this.locationSearch.detail;
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
        },
        logout() {
            this.$store.dispatch("LOGOUT", this.user);
        }
    }
};
</script>
