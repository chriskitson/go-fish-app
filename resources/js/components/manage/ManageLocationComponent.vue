<template>
    <div class="mb-8">
        <h3 class="my-8 text-xl font-semibold text-red-200">
            Location
        </h3>
        <div class="md:grid md:grid-cols-2 md:gap-6">
            <div class="mb-8 md:mb-0 md:col-span-2">
                <label class="block mb-2 font-semibold text-grey-300"
                    >Find Location</label
                >
                <google-places-autocomplete
                    class="w-full h-9x"
                    :value="venueSearch.search"
                    @resultChanged="findVenue"
                >
                    <div slot="input" slot-scope="{ context, events, actions }">
                        <input
                            v-model="context.input"
                            @focus="events.inputHasReceivedFocus"
                            @input="events.inputHasChanged"
                            @keydown.enter.prevent="actions.selectItemFromList"
                            @keydown.down.prevent="actions.shiftResultsSelection"
                            @keydown.up.prevent="actions.unshiftResultsSelection"
                            type="search"
                            placeholder="Enter a city, post code or location"
                            :class="
                                `w-full p-2 mb-5 text-sm border rounded-md b-grey-200 disabled:background-grey-200${errorStyle(
                                    'place_id'
                                )}`
                            "
                        />
                    </div>
                </google-places-autocomplete>
            </div>
            <div class="mb-8 md:mb-0">
                <label class="block mb-2 font-semibold text-grey-300"
                    >Address</label
                >
                <textarea
                    v-model="venue.address"
                    class="w-full h-32 p-4 text-sm border rounded-md b-grey-200 disabled:background-grey-200"
                    :disabled="true"
                ></textarea>
            </div>
            <div class="mb-8 md:mb-0">
                <label class="block mb-2 font-semibold text-grey-300"
                    >Google Maps Place Id</label
                >
                <input
                    type="text"
                    class="w-full p-2 mb-5 text-sm border rounded-md b-grey-200 disabled:background-grey-200"
                    :disabled="true"
                    v-model="venue.place_id"
                />
            </div>
        </div>
    </div>
</template>

<script>
import { GooglePlacesAutocomplete } from "vue-better-google-places-autocomplete";
export default {
    props: ["loading", "venue", "venueSearch", "manageVenueErrorFields"],
    components: {
        GooglePlacesAutocomplete
    },
    methods: {
        errorStyle(key) {
            return this.manageVenueErrorFields?.indexOf(key) > -1
                ? " border-red-200"
                : "";
        },
        findVenue({ place_id, formatted_address }) {
            this.venue.place_id = place_id;
            this.venue.address = formatted_address;
        }
    }
};
</script>
