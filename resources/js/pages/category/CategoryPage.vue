<template>
    <div class="w-full max-w-5xl px-4 mx-auto">
        <banner-component
            :imageURL="venueCategoryDetail.image"
        ></banner-component>
        <venue-list-component
            :title="categoryTitle"
            :venues="venueCategory"
            :live="true"
            :display="12"
            :userPosition="
                venueCategoryDetail.id !== 'near' ? null : userPosition
            "
            @showLocation="showLocationSearch"
        ></venue-list-component>
    </div>
</template>

<script>
import { mapState } from "vuex";
export default {
    computed: {
        ...mapState({
            live: state => state.live,
            venueCategory: state => state.venueCategory,
            venueCategoryDetail: state => state.venueCategoryDetail,
            userPosition: state => state.userPosition,
            user: state => state.user,
            categoryTitle: state => {
                if (!isNaN(state.venueCategoryDetail.id)) {
                    return `Great fishing venues in ${state.venueCategoryDetail.name}`;
                } else {
                    return state.venueCategoryDetail.name;
                }
            }
        })
    },
    methods: {
        showLocationSearch(show) {
            this.$store.dispatch("LOCATION_SEARCH_SHOW", show);
        },
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
        getLocationData(queryString) {
            const { user } = this;
            this.$store.dispatch("VENUES_NEAR", {
                user,
                queryString
            });
        }
    },
    mounted() {
        if (this.venueCategoryDetail.id === "near") {
            this.getUserPosition();
        }
    }
};
</script>
