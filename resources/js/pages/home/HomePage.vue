<template>
    <main class="w-full" id="app">
        <header-component></header-component>
        <home-component
            :venues="venues"
            :live="live"
            :userPosition="userPosition"
            :venueSearch="venueSearch"
            :dateSearch="dateSearch"
            @showLocation="showLocationSearch"
            @setLocation="setVenueLocation"
            @setDate="setDate"
            @searchVenues="searchVenues"
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
import Page from "../page.component.js";
export default Page;
</script>
