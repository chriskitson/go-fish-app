<template>
  <div class="mb-8">
    <h3 class="my-8 text-xl font-semibold text-red-200">Subscription</h3>
    <div class="bg-white p-4 mb-8 border-grey-300 border rounded shadow-sm">
      <h4 class="font-semibold mb-4 text-red-200">Payment Plan</h4>
      <div v-for="plan in prices" :key="plan.id" class="flex items-center mb-3 p-2 border border-grey-100 rounded hover:bg-grey-50 transition cursor-pointer">
        <input
          type="radio"
          :id="plan.id"
          :value="plan.id"
          v-model="venue.payment_model"
          class="mr-3 cursor-pointer"
        />
        <label :for="plan.id" class="text-sm font-medium cursor-pointer flex-1">
          {{ plan.name }}
        </label>
      </div>
      <button
        @click="$emit('updateModel')"
        class="mt-4 px-3 py-1 text-xs text-white bg-red-200 rounded hover:bg-red-300"
      >
        Update Payment Plan
      </button>
    </div>

    <div v-if="selectedPlan">
      <div v-if="selectedPlan.monthly_fee > 0">
        <p class="mb-4">
          This plan requires a monthly subscription of <strong>{{ formatCurrency(selectedPlan.monthly_fee) }}</strong> plus <strong>{{ selectedPlan.commission }}% commission</strong> on ticket sales.
        </p>

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
          <p class="mb-4">You do not have an active subscription with GoFish.</p>
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
      <div v-else class="bg-white p-4 mb-8 border-grey-300 border text-sm italic rounded">
        <p>
          You are currently on the Commission-only model. You will be charged a flat {{ selectedPlan.commission }}%
          commission on all tickets sold via GoFish. No monthly fee applies.
        </p>
      </div>
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
  computed: {
    selectedPlan() {
      if (!this.prices || !Array.isArray(this.prices)) return null;
      return this.prices.find(p => p.id === this.venue.payment_model);
    }
  },
};
</script>
