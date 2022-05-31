<template>
  <div class="mb-8">
    <h3 class="my-8 text-xl font-semibold text-red-200">Payment</h3>
    <p class="mb-8">Set up or manage your payment information through our payment partner Stripe.</p>
    <div class="md:grid md:grid-cols-2 md:gap-6">
      <div class="mb-8 md:mb-0">
        <label class="block mb-2 font-semibold text-grey-300"
          >Stripe Account</label
        >
        <input
          type="text"
          :class="`w-full p-2 mb-5 text-sm border rounded-md b-grey-200 disabled:background-grey-200${errorStyle(
            'account'
          )}`"
          :disabled="loading || !admin"
          v-model="venue.account"
        />
        <button
          type="submit"
          :disabled="loading"
          class="
            flex
            mt-8
            p-3
            my-1
            text-sm text-center text-white
            bg-red-200
            rounded
            focus:outline-none
            align-center
            justify-items-center
            disabled:opacity-50
          "
          @click="$emit('create')"
        >
          <div
            v-if="loading"
            :class="`border-t-4 border-b-3 rounded-full animate-spin w-4 h-4 mr-4`"
          ></div>
          Manage Payment Account
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["loading", "venue", "manageVenueErrorFields", "admin"],
  methods: {
    errorStyle(key) {
      return this.manageVenueErrorFields?.indexOf(key) > -1
        ? " border-red-200"
        : "";
    },
  },
};
</script>
