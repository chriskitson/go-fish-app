<template>
    <div class="w-full max-w-5xl px-4 mx-auto">
        <home-banner-component
            :imageURL="venueCategoryDetail.image"
            :message="venueCategoryDetail.name"
        ></home-banner-component>
        <venue-list-component
            :title="categoryTitle"
            :category="venueCategoryDetail.name"
            :venues="venueCategory"
            :live="true"
            :loading="loading"
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
            loading: state => state.loading,
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
        }
    }
};
</script>
