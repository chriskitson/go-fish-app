<template>
  <div class="w-full max-w-5xl px-4 mx-auto">
    <home-banner-component
      :imageURL="venueCategoryDetail.image"
      :message="venueCategoryDetail.name"
      position="bottom"
    ></home-banner-component>
    <h2 v-if="venueCategoryDetail.is_region" class="flex items-center mt-10 mb-2 text-xl font-semibold">
      Counties in {{ venueCategoryDetail.name }}
    </h2>
    <div
      v-if="venueCategoryDetail.is_region && live && !loading && venueCategory"
      class="grid w-full grid-cols-2 gap-4 mb-6 md:grid-cols-4"
    >
      <category-item-component
        v-for="(cat, i) in venueCategory"
        :key="`region-cat-${i}`"
        :live="true"
        :category="cat"
      ></category-item-component>
    </div>

    <venue-list-component
      v-if="!venueCategoryDetail.is_region"
      :title="categoryTitle"
      :category="venueCategoryDetail.name"
      :venues="venueCategory"
      :live="true"
      :loading="loading"
      :display="12"
      :userPosition="venueCategoryDetail.id !== 'near' ? null : userPosition"
      @showLocation="showLocationSearch"
    ></venue-list-component>
  </div>
</template>

<script>
import { mapState } from "vuex";
export default {
  computed: {
    ...mapState({
      live: (state) => state.live,
      loading: (state) => state.loading,
      venueCategory: (state) => state.venueCategory,
      venueCategoryDetail: (state) => state.venueCategoryDetail,
      userPosition: (state) => state.userPosition,
      user: (state) => state.user,
      categoryTitle: (state) => {
        if (!isNaN(state.venueCategoryDetail.id)) {
          return `Great fishing venues in ${state.venueCategoryDetail.name}`;
        } else {
          return state.venueCategoryDetail.name;
        }
      },
    }),
  },
  methods: {
    showLocationSearch(show) {
      this.$store.dispatch("LOCATION_SEARCH_SHOW", show);
    },
  },
};
</script>
