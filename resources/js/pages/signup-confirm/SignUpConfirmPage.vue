<template>
  <div class="w-full max-w-5xl px-4 mx-auto">
    <div v-if="live">
      <h1 class="mt-16 mb-4 text-xl font-semibold text-red-200">
        Thank you for signing {{venue.name}}!
      </h1>
      <p>Thank you, your subscription has been set up. We now need your payment details so you can begin receiving payments.</p>
      <p class="mt-8">
        <a
          :href="venue.account_link"
          class="
            flex
            items-center
            w-full
            px-4
            py-2
            text-lg
            font-semibold
            text-center text-white
            bg-white bg-red-200
            rounded-md
            cursor-pointer
            justify-content
            md:w-auto
          "
        >
          <span class="flex-1">Set up Stripe payments</span>
          <icon name="chevron-right" class="w-5 h-5 ml-2 text-white" />
        </a>
      </p>
    </div>
    <div v-if="!live">
      <h1 class="mt-16 mb-4 text-xl font-semibold text-red-200 h-96">
        Loading...
      </h1>
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";
export default {
  computed: {
    ...mapState({
      live: (state) => state.live,
      venue: (state) => state.venueSignUpDetail,
    }),
  },
  mounted() {
    if (this.$route?.params?.id !== "") {
      this.getMySubscription(this.$route.params.id);
    }
  },
  methods: {
    getMySubscription(session) {
      return this.$store.dispatch("MY_VENUE_SUBSCRIPTION_GET", {
        session,
      });
    },
  },
};
</script>
