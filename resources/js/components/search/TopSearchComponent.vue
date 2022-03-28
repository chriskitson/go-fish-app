<template>
  <div class="flex items-center mx-4">
    <div
      class="flex flex-row flex-wrap items-center w-auto w-full text-sm md:h-12"
    >
      <div
        class="
          flex
          items-center
          w-full
          h-12
          px-2
          mb-2
          bg-white
          md:border-t
          md:border-b
          md:border-l
          md:mb-0
          md:rounded-tl-lg
          md:rounded-bl-lg
          md:w-56
          border-grey-200
        "
      >
        <client-only>
          <date-picker
            :value="date"
            type="date"
            :clearable="false"
            :disabled-date="disableDate"
            v-on:change="$emit('change', $event)"
            class="w-full top-date-picker"
            format="DD/MM/YYYY"
          ></date-picker>
        </client-only>
      </div>
      <div
        class="
          flex
          items-center
          w-full
          h-12
          px-2
          mb-2
          bg-white
          md:border-t md:border-b md:border-l md:w-96
          border-grey-200
          md:mb-0
        "
      >
        <span class="mr-2"
          ><icon name="location-marker" class="w-6 h-6"
        /></span>
        <google-places-autocomplete
          class="w-full h-9 md:w-80"
          :value="venueSearch.search"
          @resultChanged="(placeDetail) => $emit('set', placeDetail)"
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
              placeholder="Enter a city, post code or location"
              class="w-full px-4 py-2 rounded-md"
            />
          </div>
        </google-places-autocomplete>
      </div>
      <button
        class="
          w-full
          h-12
          px-8
          text-white
          bg-orange-200
          border border-orange-200
          rounded-lg
          md:w-auto
        "
        @click="$emit('search')"
      >
        Search
      </button>
    </div>
  </div>
</template>

<script>
import { GooglePlacesAutocomplete } from "vue-better-google-places-autocomplete";
import ClientOnly from "vue-client-only";
import DatePicker from "vue2-datepicker";
export default {
  props: ["venueSearch", "date"],
  components: {
    GooglePlacesAutocomplete,
    ClientOnly,
    DatePicker,
  },
  methods: {
    disableDate(date) {
      return date < new Date();
    },
  },
};
</script>
