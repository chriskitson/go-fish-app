<template>
  <div class="container flex flex-col items-center flex-1 px-2 mx-auto">
    <div
      class="
        w-full
        px-6
        py-8
        text-black
        bg-white
        rounded
        shadow-md
        bg-opacity-80
      "
    >
      <h1
        class="mb-8 text-xl text-center text-red-200"
        v-if="!register.confirmed"
      >
        Sign up to GOFish
      </h1>
      <h1
        class="mb-8 text-xl text-center text-red-200"
        v-if="register.confirmed"
      >
        Thank you for adding your fishery
      </h1>
      <alert-component
        v-if="register.errors.length > 0"
        :message="register.errors.join(', ')"
        type="error"
      ></alert-component>
      <alert-component
        v-if="register.messages.length > 0"
        :message="register.messages.join(', ')"
        type="success"
      ></alert-component>
      <div v-if="register.confirmed">
        <p>
          To complete your sign up and start accepting payments from GoFish, you
          must provide your bank details to Stripe, our payment partner.
        </p>
        <a
          :href="register.stripeUrl"
          class="
            flex
            items-center
            w-full
            px-4
            py-2
            mt-4
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
          <span class="flex-1">Proceed to Stripe</span>
          <icon name="chevron-right" class="w-5 h-5 ml-2 text-white" />
        </a>
      </div>
      <div v-if="!register.confirmed">
        <p class="mb-4">
          If you are a fishery owner we would love you to use our platform to
          advertise, sell and manage your tickets online.
        </p>
        <p class="mb-4">Our pricing model is <strong>simple</strong>:</p>
        <ul class="list-inside list-disc mb-8 text-sm">
          <li>
            You choose one of our
            <a href="#" class="text-red-200">subscriptions</a> (from &pound;35
            per month)
          </li>
          <li>GOFish collect <strong>&pound;1 booking fee</strong> for each ticket sold</li>
          <li>
            Our payment partner (Stripe) collect <strong>1.4% + 20p</strong> (per transaction)
          </li>
          <li class="mt-4 italic">
            E.g. &pound;10 ticket, GoFish collect &pound;1, Stripe collect 34p, you get &pound;8.66</li>
        </ul>
        <google-places-autocomplete
          class="w-full h-9x"
          :value="register.search"
          @resultChanged="findVenue"
        >
          <div slot="input" slot-scope="{ context, events, actions }">
            <input
              autocomplete="off"
              v-model="context.input"
              @focus="events.inputHasReceivedFocus"
              @input="events.inputHasChanged"
              @keydown.enter.prevent="actions.selectItemFromList"
              @keydown.down.prevent="actions.shiftResultsSelection"
              @keydown.up.prevent="actions.unshiftResultsSelection"
              type="search"
              placeholder="Enter address of fishery"
              :class="`w-full p-3 mb-4 text-sm border rounded border-grey-100 disabled:background-grey-200${errorStyle(
                'place_id'
              )}`"
            />
          </div>
        </google-places-autocomplete>
        <hr />
        <input
          type="text"
          class="block w-full p-3 mb-4 text-sm border rounded border-grey-100"
          name="fullname"
          placeholder="Full Name"
          v-model="register.name"
        />
        <input
          type="text"
          class="block w-full p-3 mb-4 text-sm border rounded border-grey-100"
          name="email"
          placeholder="Email"
          v-model="register.email"
        />
        <input
          type="password"
          class="block w-full p-3 mb-4 text-sm border rounded border-grey-100"
          name="password"
          placeholder="Password"
          v-model="register.password"
        />
        <input
          type="password"
          class="block w-full p-3 mb-4 text-sm border rounded border-grey-100"
          name="confirm_password"
          placeholder="Confirm Password"
          v-model="register.confirm"
        />
        <select
          name="subscription"
          class="block w-full p-3 mb-4 text-sm border rounded border-grey-100"
          v-model="register.subscription"
        >
          <option value="lite">
            Fishery Manager - Lite - &pound;35 per month
          </option>
        </select>

        <button
          type="submit"
          :disabled="loading || loggedIn"
          class="
            flex
            w-full
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
          @click="$emit('register')"
        >
          <div
            v-if="loading"
            :class="`border-t-4 border-b-3 rounded-full animate-spin w-4 h-4 mr-4`"
          ></div>
          Add Fishery
        </button>
        <div class="mt-4 text-xs text-center text-grey-300">
          By signing up, you agree to the
          <a
            class="no-underline border-b border-grey-300 text-grey-300"
            href="#"
          >
            Terms of Service
          </a>
          and
          <a
            class="no-underline border-b border-grey-300 text-grey-300"
            href="#"
          >
            Privacy Policy
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { GooglePlacesAutocomplete } from "vue-better-google-places-autocomplete";
export default {
  props: ["register", "loggedIn", "loading"],
  components: {
    GooglePlacesAutocomplete,
  },
  methods: {
    errorStyle(key) {
      return this.manageVenueErrorFields?.indexOf(key) > -1
        ? " border-red-200"
        : "";
    },
    findVenue({ place_id, formatted_address, name }) {
      this.register.fisheryName = name;
      this.register.placeId = place_id;
      this.register.address = formatted_address;
    },
  },
};
</script>
