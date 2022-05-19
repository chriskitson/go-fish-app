<template>
  <div class="w-full max-w-5xl px-4 mx-auto">
    <div class="grid grid-cols-3 gap-6 mt-10 mb-20">
      <div class="col-span-3">
        <div class="flex justify-end w-full">
          <a
            href="/add-venue"
            class="
              flex
              items-center
              justify-center
              px-3
              py-2
              my-4
              text-sm text-white
              bg-red-200
              rounded-lg
              disabled:opacity-50
            "
          >
            <icon name="plus" class="w-4 h-4 mr-2" />
            Add Venue
          </a>
        </div>
        <ul>
          <li
            v-for="(venue, index) in venues"
            :key="venue.id"
            :class="`flex items-center justify-center p-2 mb-2${
              index % 2 ? ' bg-white' : ' bg-grey-100'
            }`"
          >
            <a
              :href="`/manage-venues/${venue.id}`"
              class="flex-1 text-red-200 hover:underline"
              >{{ venue.name }}</a
            >
            <span
              class="ml-2 flex items-center justify-center px-3 text-xs"
              v-if="venue.claimed"
            >
              <a :href="`mailto:${venue.claimed_user}`">{{
                venue.claimed_user
              }}</a>
            </span>
            <span
              :class="`ml-2 flex items-center justify-center px-3 py-2 text-sm text-white rounded-lg disabled:opacity-50 ${
                venue.claimed ? 'bg-success' : 'bg-grey-200'
              }`"
            >
              <icon name="user-circle" class="w-4 h-4" />
            </span>
            <span
              :class="`ml-2 flex items-center justify-center px-3 py-2 text-sm text-white rounded-lg disabled:opacity-50 ${
                venue.payment_active ? 'bg-success' : 'bg-grey-200'
              }`"
            >
              <icon name="currency-pound" class="w-4 h-4" />
            </span>
            <button
              @click="deleteVenue(venue.id)"
              class="
                ml-2
                flex
                items-center
                justify-center
                px-3
                py-2
                text-sm text-white
                bg-orange-200
                rounded-lg
                disabled:opacity-50
              "
            >
              <icon name="trash" class="w-4 h-4" />
            </button>
          </li>
        </ul>
      </div>
    </div>
    <page-spinner-component v-if="loading" />
  </div>
</template>

<script>
import { mapState } from "vuex";
export default {
  computed: {
    ...mapState({
      venues: (state) => state.manageVenues,
      live: (state) => state.live,
      basket: (state) => state.basket,
      venueDetail: (state) => state.venueDetail,
      loggedIn: (state) => state.user.loggedIn,
      user: (state) => state.user,
      userTickets: (state) => state.userTickets,
      loading: (state) => state.loading
    }),
  },
  methods: {
    deleteVenue(id) {
      const { user } = this;
      this.$store.dispatch("VENUE_DELETE", {
        id,
        user,
      });
    },
  },
  mounted() {
    return this.$store.dispatch("VENUES_ADMIN", {
      user: this.user,
    });
  },
};
</script>
