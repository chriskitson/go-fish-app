<template>
  <div class="w-full max-w-5xl px-4 mx-auto">
    <home-banner-component
      imageURL="/images/bg3.jpg"
      message="The fastest and easiest way to book your next fishing trip!"
    ></home-banner-component>
    <venue-list-component
      :title="
        userPosition === null
          ? 'Fisheries in United Kingdom'
          : 'Fisheries near me'
      "
      category="my area"
      :venues="venues"
      :live="live"
      :loading="loading"
      :userPosition="userPosition"
      :display="4"
      @showLocation="showLocationSearch"
    ></venue-list-component>
    <category-list-component
      title="Explore United Kingdom"
      :categories="categories"
      :live="true"
    ></category-list-component>
  </div>
</template>

<script>
import { mapState } from "vuex";
export default {
  computed: {
    ...mapState({
      venues: (state) => state.venues,
      live: (state) => state.live,
      loading: (state) => state.loading,
      userPosition: (state) => state.userPosition,
      locationSearch: (state) => state.locationSearch,
      venueDetail: (state) => state.venueDetail,
      categories: (state) => state.categories,
    }),
  },
  data: () => ({
    types: [
      {
        id: 1,
        name: "Sea fishing",
        image: "/images/river.jpg",
      },
      {
        id: 1,
        name: "Trout",
        image: "/images/river.jpg",
      },
      {
        id: 1,
        name: "Salmon",
        image: "/images/river.jpg",
      },
      {
        id: 1,
        name: "Fly fishing",
        image: "/images/river.jpg",
      },
    ],
  }),
  methods: {
    showLocationSearch(show) {
      this.$store.dispatch("LOCATION_SEARCH_SHOW", show);
    },
  },
};
</script>
