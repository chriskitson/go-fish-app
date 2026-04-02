<template>
  <div class="w-full max-w-5xl px-4 mx-auto">
    <overlay-component
      v-if="overlayShown"
      :html="overlayContent"
      @close="hideOverlay"
    ></overlay-component>
    <div class="grid grid-cols-3 gap-6 mt-5 mb-20 md:mt-10">
      <div class="col-span-3 md:col-span-1">
        <div class="flex justify-center items-center">
          <img
            v-if="venueDetail.image"
            :src="venueDetail.image"
            class="w-auto mb-5 rounded-md max-h-40 md:w-full md:max-h-full"
            :alt="`${venueDetail.name} image`"
          />
          <img
            v-if="
              !venueDetail.image &&
              venueDetail.photos &&
              venueDetail.photos.length > 0
            "
            :src="venueDetail.photos[0].url"
            class="w-auto mb-5 rounded-md max-h-40 md:w-full md:max-h-full"
            :alt="`${venueDetail.name} image`"
          />
        </div>
        <div class="flex items-center text-xs text-gold">
          <rating-component
            :current="venueDetail.rating || 0"
            :max="5"
          ></rating-component>
          {{ venueDetail.rating || 0 }} / 5
        </div>
        <h1 class="text-xl font-semibold">{{ venueDetail.name }}</h1>
        <p class="mb-2 md:mb-10 text-sm font-semibold">
          {{ venueDetail.address }}
        </p>
        <p class="text-sm hidden md:block" v-html="venueDetail.description"></p>
        <div class="block md:hidden">
          <span
            class="text-sm"
            v-html="
              venueDetail.description.length > 100
                ? `${venueDetail.description.substring(0, 100)}...`
                : venueDetail.description
            "
          ></span>
          <button @click="viewDescription()" class="text-sm text-red-200">
            Read more
          </button>
        </div>
        <client-only>
          <social-share-component 
            :title="venueDetail.name" 
            :url="venueUrl"
          />
        </client-only>

        <div class="flex mt-5">
          <a
            :href="directionsURL"
            target="_blank"
            class="
              flex
              items-center
              justify-center
              px-3
              py-1
              mr-2
              text-sm text-white
              bg-red-200
              rounded-lg
            "
            v-if="venueDetail.place_id !== ''"
          >
            <icon name="location-marker" class="w-4 h-4 mr-2" />
            Directions
          </a>
          <a
            :href="`https://search.google.com/local/writereview?placeid=${venueDetail.place_id}`"
            target="_blank"
            class="
              flex
              items-center
              justify-center
              px-3
              py-1
              mr-2
              text-sm text-white
              bg-red-200
              rounded-lg
            "
            v-if="venueDetail.place_id !== ''"
          >
            <icon name="pencil" class="w-4 h-4 mr-2" />
            Review
          </a>
          <button
            @click="viewRules()"
            v-if="venueDetail.rules !== ''"
            class="
              flex
              items-center
              justify-center
              px-3
              py-1
              mr-2
              text-sm text-white
              bg-red-200
              rounded-lg
              md:hidden
            "
          >
            <icon name="view-list" class="w-4 h-4 mr-2" />
            Rules
          </button>
        </div>
        <div
          class="p-5 mt-10 border border-grey-200 text-grey-300 hidden md:block"
          v-if="venueDetail.rules !== ''"
        >
          <h2 class="mb-2 font-semibold">Rules</h2>
          <div v-html="venueDetail.rules"></div>
        </div>
      </div>
      <div class="col-span-3 md:col-span-2">
        <div
          v-if="!venueDetail.managed"
          class="p-4 mb-5 bg-grey-100 rounded-xl"
        >
          <h3 class="mb-2 font-semibold">
            {{ venueDetail.name }} is currently not managed on GoFish.
          </h3>
          <p class="mb-2">
            If you would like to claim it please click the button below and
            register:
          </p>
          <a
            :href="`/signup?p=${venueDetail.place_id}&a=${encodeURIComponent(
              venueDetail.address
            )}&n=${encodeURIComponent(venueDetail.name)}`"
            class="
              flex
              items-center
              px-4
              py-2
              text-md
              font-semibold
              text-center text-white
              bg-red-200
              rounded-md
              cursor-pointer
              justify-content
              md:w-auto
            "
          >
            <span class="flex-1"
              >Register {{ venueDetail.name }} on GoFish!</span
            >
            <icon name="chevron-right" class="w-5 h-5 ml-2 text-white" />
          </a>
        </div>
        <banner-component
          :text="`This venue does not have any tickets available to purchase on GoFish.${
            venueDetail.phone
              ? ' For more information please call ' + venueDetail.phone + '.'
              : ''
          }`"
          v-if="venueDetail.managed && venueDetail.ticket_count === 0"
        />
        <div v-if="venueDetail.managed && venueDetail.ticket_count > 0">
          <date-navigation-component
            :date="currentDate"
            :prevDisabled="venueDetail.date < new Date()"
            @back="dateBack"
            @forward="dateForward"
          ></date-navigation-component>
          <ticket-list-component
            :title="ticketTitle"
            :tickets="venueDetail.tickets"
            :live="venueDetail.ticketsLoaded && !loading"
            :auth="false"
            :loggedIn="loggedIn"
            display="4"
            @book="bookTickets"
          ></ticket-list-component>
        </div>
        <div
          class="flex items-center mt-10 mb-10"
          v-if="
            loggedIn &&
            basket.length > 0 &&
            venueDetail.tickets &&
            venueDetail.tickets.length > 0
          "
        >
          <span class="flex-1"> </span>
          <a
            href="/basket"
            class="
              flex
              items-center
              w-full
              px-4
              py-2
              text-lg
              font-semibold
              text-center text-white
              bg-red-200
              rounded-md
              cursor-pointer
              justify-content
              md:w-auto
            "
          >
            <span class="flex-1">Proceed to Basket</span>
            <icon name="chevron-right" class="w-5 h-5 ml-2 text-white" />
          </a>
        </div>
        <photos-component
          v-if="!loading && live && photoGallery && photoGallery.length > 0"
          :photos="photoGallery"
          :name="venueDetail.name"
        ></photos-component>
        <reviews-component
          v-if="!loading && live && venueDetail.reviews && venueDetail.reviews.length > 0"
          :name="venueDetail.name"
          :reviews="venueDetail.reviews"
        />
      </div>
    </div>
  </div>
</template>

<script>
import ClientOnly from "vue-client-only";
import VueMasonryWall from "vue-masonry-wall";
import { mapState } from "vuex";
import {
  formatDateDisplay,
  formatLongDateDisplay,
  formatDateDisplayFromTime,
} from "../../utils";
import { trackViewedVenue } from "../../utils/klaviyo";
export default {
  components: {
    ClientOnly,
    VueMasonryWall
  },
  data: () => ({
    formatDateDisplayFromTime,
    overlayShown: false,
    overlayContent: "bananananaassss adasdasdasd",
  }),
  computed: {
    ...mapState({
      venues: (state) => state.venues,
      live: (state) => state.live,
      loading: (state) => state.loading,
      basket: (state) => state.basket,
      venueDetail: (state) => state.venueDetail,
      loggedIn: (state) => state.user.loggedIn,
      user: (state) => state.user,
      ticketTitle: (state) =>
        state.venueDetail.tickets.length > 0
          ? `Tickets from £${
              state.venueDetail.tickets.sort((a, b) => a.cost - b.cost)[0].cost
            } for ${formatDateDisplay(state.venueDetail.date)}:`
          : "No tickets available",
      currentDate: (state) => formatLongDateDisplay(state.venueDetail.date),
      directionsURL: (state) => {
        return `https://www.google.com/maps/dir/?api=1&origin=${
          state.userPosition?.town || ""
        }&destination_place_id=${state.venueDetail.place_id}&destination=${
          state.venueDetail.address
        }`;
      },
      photoGallery: (state) => {
        return state.venueDetail.photos?.length > 0
          ? state.venueDetail.photos.map((p) => ({
              image: p.url,
            }))
          : [];
      },
      venueUrl() {
        if (typeof window === 'undefined') return `/venue/${this.venueDetail.id}`;
        return `${window.location.protocol}//${window.location.host}/venue/${this.venueDetail.id}`;
      }
    }),
  },
  mounted() {
    this.getVenueTickets(this.venueDetail.id, this.venueDetail.date);
    const { id, name, image, photos } = this.venueDetail;
    let venueImage = "";
    if (image) {
      venueImage = image;
    } else if (photos && photos.length > 0) {
      venueImage = photos[0].url;
    }
    trackViewedVenue({
      id,
      name,
      image: venueImage,
      url: `${location.protocol}//${location.host}/venue/${id}`,
    });
  },
  methods: {
    getVenueTickets(id, date) {
      return this.$store.dispatch("VENUE_TICKETS_GET", {
        id,
        date,
        user: this.user,
      });
    },
    bookTickets(data) {
      if (!this.loggedIn) {
        localStorage.setItem("referrer", this.$route.fullPath);
        window.location.href = "/login";
      } else {
        const { ticket_id, venue_id, qty } = data;
        const { date } = this.venueDetail;
        this.$store.dispatch("BASKET_ADD", {
          ticket_id,
          venue_id,
          date,
          qty,
          user: this.user,
        });
      }
    },
    dateBack() {
      const today = new Date(this.venueDetail.date);
      const date = new Date(today.getTime() - 24 * 60 * 60 * 1000);
      this.getVenueTickets(this.venueDetail.id, date);
    },
    dateForward() {
      const today = new Date(this.venueDetail.date);
      const date = new Date(today.getTime() + 24 * 60 * 60 * 1000);
      this.getVenueTickets(this.venueDetail.id, date);
    },
    viewRules() {
      this.overlayContent = this.venueDetail.rules;
      this.overlayShown = true;
    },
    viewDescription() {
      this.overlayContent = this.venueDetail.description;
      this.overlayShown = true;
    },
    hideOverlay() {
      this.overlayContent = "";
      this.overlayShown = false;
    },
  },
};
</script>
