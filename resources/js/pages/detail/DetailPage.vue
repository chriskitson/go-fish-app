<template>
    <main class="w-full" id="app">
        <header-component></header-component>
        <detail-component
            :live="live"
            :venueSearch="venueSearch"
            :dateSearch="dateSearch"
            :venueDetail="venueDetail"
            @showLocation="showLocationSearch"
            @setLocation="setVenueLocation"
            @setDate="setDate"
            @searchVenues="searchVenues"
        ></detail-component>
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
import Page from "../page.component.js";
export default {
    mixins: [Page],
    mounted() {
        this.getVenueTickets(this.$store.state.venueDetail.id);
    }
};
</script>
