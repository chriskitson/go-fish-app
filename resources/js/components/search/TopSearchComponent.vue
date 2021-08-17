<template>
    <div class="flex items-center w-full mt-5">
        <div
            class="flex items-center w-auto h-12 max-w-5xl text-sm border rounded-lg border-light bg-primary"
        >
            <div
                class="flex items-center h-12 px-2 bg-white border-t border-b rounded-tl-lg rounded-bl-lg w-50 border-light"
            >
                <span class="mr-2"
                    ><icon name="calendar" class="w-6 h-6"
                /></span>
                <input
                    type="text"
                    class="h-8 px-2 w-30"
                    placeholder=""
                    :value="date"
                />
            </div>
            <div
                class="flex items-center h-12 px-2 bg-white border-t border-b border-l w-96 border-light top"
            >
                <span class="mr-2"
                    ><icon name="location-marker" class="w-6 h-6"
                /></span>
                <google-places-autocomplete
                    class="h-9 w-80"
                    @resultChanged="placeDetail => $emit('set', placeDetail)"
                >
                    <div slot="input" slot-scope="{ context, events, actions }">
                        <input
                            v-model="context.input"
                            @focus="events.inputHasReceivedFocus"
                            @input="events.inputHasChanged"
                            @keydown.enter.prevent="actions.selectItemFromList"
                            @keydown.down.prevent="
                                actions.shiftResultsSelection
                            "
                            @keydown.up.prevent="
                                actions.unshiftResultsSelection
                            "
                            type="search"
                            placeholder="Enter a city, post code or location"
                            class="w-full px-4 py-2 rounded-md"
                        />
                    </div>
                </google-places-autocomplete>
            </div>

            <button
                class="h-12 px-8 text-white border rounded-lg bg-primary border-primary"
                @click="$emit('search')"
            >
                Search
            </button>
        </div>
    </div>
</template>

<script>
import { GooglePlacesAutocomplete } from "vue-better-google-places-autocomplete";
export default {
    props: ["venueSearch", "date"],
    components: {
        GooglePlacesAutocomplete
    }
};
</script>
