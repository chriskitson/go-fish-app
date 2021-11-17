<template>
    <div class="w-full max-w-5xl px-4 mx-auto">
        <banner-component></banner-component>
        <venue-list-component
            title="Fisheries near me"
            :venues="venues"
            :live="live"
            :userPosition="userPosition"
            @showLocation="showLocationSearch"
        ></venue-list-component>
        <category-list-component
            title="Explore Northern Ireland"
            :categories="categories"
            :live="true"
        ></category-list-component>
        <category-list-component
            title="How do you GoFish?"
            :categories="types"
            :live="true"
        ></category-list-component>
    </div>
</template>

<script>
import { mapState } from "vuex";
export default {
    computed: {
        ...mapState({
            venues: state => state.venues,
            live: state => state.live,
            userPosition: state => state.userPosition,
            locationSearch: state => state.locationSearch,
            venueDetail: state => state.venueDetail,
            categories: state => state.categories
        })
    },
    data: () => ({
        types: [
            {
                id: 1,
                name: "Sea fishing",
                image: "/images/river.jpg"
            },
            {
                id: 1,
                name: "Trout",
                image: "/images/river.jpg"
            },
            {
                id: 1,
                name: "Salmon",
                image: "/images/river.jpg"
            },
            {
                id: 1,
                name: "Fly fishing",
                image: "/images/river.jpg"
            }
        ]
    }),
    methods: {
        showLocationSearch(show) {
            this.$store.dispatch("LOCATION_SEARCH_SHOW", show);
        }
    }
};
</script>
