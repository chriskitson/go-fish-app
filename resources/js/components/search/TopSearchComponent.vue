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
                    placeholder="Monday 9th August"
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
                    placeholder="Enter your city, post code or location"
                    @resultChanged="placeDetail => $emit('set', placeDetail)"
                />
            </div>

            <button
                class="h-12 px-8 text-white border rounded-lg bg-primary border-primary"
            >
                Search
            </button>
        </div>
    </div>
</template>

<script>
import { GooglePlacesAutocomplete } from "vue-better-google-places-autocomplete";
export default {
    props: ["venueSearch"],
    components: {
        GooglePlacesAutocomplete
    }
};
</script>
