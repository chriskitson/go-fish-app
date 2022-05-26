<template>
  <main
    :class="`md:mt-4 m-auto bg-white text-left max-w-screen-lg ${bgColor}`"
    id="app"
  >
    <header-component
      :user="user"
      :live="live"
      :basketCount="basketCount"
      :basketTotal="basketTotal"
      @logout="logout"
      @cache="clearCache"
    ></header-component>
    <div class="w-full py-3 mx-auto md:max-w-5xl bg-grey-100" v-if="showSearch">
      <top-search-component
        :venueSearch="venueSearch"
        :date="dateSearch"
        @set="setVenueLocation"
        @search="searchVenues"
        @change="change"
      ></top-search-component>
    </div>
    <router-view></router-view>
    <footer-component
      :categories="allCategories"
      :usefulLinks="usefulLinks"
      :informationLinks="informationLinks"
    ></footer-component>
    <location-component
      v-if="locationSearch.show"
      :locationSearch="locationSearch"
      @show="showLocationSearch"
      @set="setLocation"
      @update="updateLocation"
    ></location-component>
    <modal-component
      v-for="(alert, i) in alerts"
      :key="`alert-${i}`"
      :message="alert"
      type="error"
      @close="closeModal"
    ></modal-component>
  </main>
</template>
<script>
import { mapState } from "vuex";
import { formatCurrency } from "../../utils";
export default {
  computed: {
    ...mapState({
      locationSearch: (state) => state.locationSearch,
      venueSearch: (state) => state.venueSearch,
      dateSearch: (state) => state.dateSearch,
      bgColor: (state) => {
        if (
          state.path === "login" ||
          state.path === "signup" ||
          state.path === "signup/confirm"
        ) {
          return `bg-cover bg-login bg-bottom bg-grey-100`;
        }
        return "";
      },
      showSearch: (state) => state.path !== "login",
      user: (state) => state.user,
      live: (state) => state.live,
      basket: (state) => state.basket,
      alerts: (state) => state.alerts,
      basketCount: (state) =>
        state.basket.map((b) => b.basket_qty).reduce((a, b) => a + b, 0),
      basketTotal: (state) =>
        formatCurrency(
          state.basket
            .map((b) => b.basket_qty * b.ticket_cost)
            .reduce((a, b) => a + b, 0)
        ),
      allCategories: (state) => state.allCategories,
    }),
  },
  mounted() {
    this.getLocationData('');
    // TODO - uncomment below line if wish to use location based services
    // this.getUserPosition();
    this.getUserData();
    if (this.user.loggedIn) {
      this.getBasket();
    }
  },
  methods: {
    getUserPosition() {
      navigator.geolocation.getCurrentPosition(
        (position) => {
          const {
            coords: { latitude, longitude },
          } = position;
          this.getLocationData(`latitude=${latitude}&longitude=${longitude}`);
        },
        (error) => {
          this.getLocationData("");
        }
      );
    },
    getBasket() {
      this.$store.dispatch("BASKET_GET", this.user);
    },
    getUserData() {
      const { user } = this;
      if (user.loggedIn) {
        this.$store.dispatch("USER_DATA_FETCH", {
          user,
        });
      }
    },
    getLocationData(queryString) {
      const { user } = this;
      this.$store.dispatch("BOOTSTRAP_DATA_FETCH", {
        user,
        queryString,
      });
      if (this.$route.fullPath === "/category/near") {
        this.$store.dispatch("VENUES_NEAR", {
          user,
          queryString,
        });
      }
    },
    showLocationSearch(show) {
      this.$store.dispatch("LOCATION_SEARCH_SHOW", show);
    },
    updateLocation() {
      if (this.locationSearch.detail) {
        const {
          geometry: { location },
        } = this.locationSearch.detail;
        localStorage.removeItem("homeToken");
        localStorage.setItem("origin", `${location.lat()},${location.lng()}`);
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
        window.location.href = `/search/${dateSearch.getTime()}/${
          venueSearch.detail.place_id
        }`;
      }
    },
    logout() {
      this.$store.dispatch("LOGOUT", this.user);
    },
    closeModal(msg) {
      const i = this.alerts.indexOf(msg);
      this.alerts.splice(i, 1);
    },
    change(date) {
      this.$store.dispatch("DATE_SET", date);
    },
    clearCache() {
      this.$store.dispatch("CLEAR_CACHE", this.user);
    },
  },
  data: () => ({
    usefulLinks: [
      {
        url: "/login",
        name: "Join GoFish",
      },
      {
        url: `/search/${new Date(
          new Date().setDate(new Date().getDate() + 1)
        ).getTime()}/ChIJO4rQ1_3_YEgRMcXH7ywWVy4`,
        name: "Search",
      },
      {
        url: "/category/latest",
        name: "Latest Fisheries",
      },
      {
        url: "/category/near",
        name: "Fisheries Near Me",
      },
      {
        url: "/category/best",
        name: "Best Fisheries",
      },
    ],
    informationLinks: [
      {
        url: "/about",
        name: "About GoFish",
      },
      {
        url: "/contact",
        name: "Contact us",
      },
      {
        url: "/privacy",
        name: "Privacy Policy",
      },
      {
        url: "/terms",
        name: "Terms & Conditions",
      },
      {
        url: "/complaints",
        name: "Complaints Policy",
      },
      {
        url: "/faq",
        name: "FAQs",
      },
    ],
  }),
};
</script>
