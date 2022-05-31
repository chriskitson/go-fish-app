<template>
  <div class="mb-8">
    <h3 class="my-8 text-xl font-semibold text-red-200">Subscription</h3>
    <p class="mb-8">
      You will be billed according to how many tickets you sell per month:
    </p>
    <table class="w-full mb-8 text-red-200">
      <tbody>
        <tr v-for="(price, i) in prices" :key="`price-${i}`">
          <td>
            Up to {{ price.up_to ? price.up_to : "unlimited" }} tickets sold
          </td>
          <td>{{ formatCurrency(price.flat_amount / 100) }} per month</td>
        </tr>
      </tbody>
    </table>
    <div v-if="venue.subscription.confirmed">
      <p class="mb-8">
        You have an active
        <strong>{{ venue.subscription.type }}</strong> subscription with GoFish
        for <strong>{{ formatCurrency(venue.subscription.amount) }}</strong> per
        month.
      </p>
      <button
        @click="$emit('cancel')"
        class="
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
        :disabled="loading"
      >
        Cancel Subscription
      </button>
    </div>
    <div v-if="!venue.subscription.confirmed">
      <p>You do not have an active subscription with GoFish.</p>
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
        Create Subscription
      </button>
    </div>
  </div>
</template>

<script>
import { formatCurrency } from "../../utils";
export default {
  props: ["loading", "venue", "prices"],
  data: () => ({
    formatCurrency,
  }),
};
</script>
