<template>
    <div
        class="fixed inset-0 z-10 overflow-y-auto"
        aria-labelledby="modal-title"
        role="dialog"
        aria-modal="true"
    >
        <div
            class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0"
        >
            <div
                class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"
                aria-hidden="true"
            ></div>
            <span
                class="hidden sm:inline-block sm:align-middle sm:h-screen"
                aria-hidden="true"
                >&#8203;</span
            >
            <div
                class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
            >
                <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto text-white bg-red-200 rounded-full sm:mx-0 sm:h-10 sm:w-10"
                        >
                            <icon name="location-marker" class="w-6 h-6" />
                        </div>
                        <div
                            class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left"
                        >
                            <h3
                                class="text-lg font-medium leading-6 text-gray-900"
                                id="modal-title"
                            >
                                Update my location
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    This helps us find where you're currently
                                    located so we can help you find fisheries
                                    near you.
                                </p>
                            </div>
                            <div class="mt-5 mb-5 location">
                                <google-places-autocomplete
                                    :value="locationSearch.search"
                                    required
                                    class="h-9 w-80"
                                    @resultChanged="
                                        placeDetail => $emit('set', placeDetail)
                                    "
                                >
                                    <div
                                        slot="input"
                                        slot-scope="{
                                            context,
                                            events,
                                            actions
                                        }"
                                    >
                                        <input
                                            v-model="context.input"
                                            @focus="
                                                events.inputHasReceivedFocus
                                            "
                                            @input="events.inputHasChanged"
                                            @keydown.enter.prevent="
                                                actions.selectItemFromList
                                            "
                                            @keydown.down.prevent="
                                                actions.shiftResultsSelection
                                            "
                                            @keydown.up.prevent="
                                                actions.unshiftResultsSelection
                                            "
                                            type="search"
                                            placeholder="Enter your city, post code or location"
                                            class="w-full px-4 py-2 border rounded-md border-light"
                                        />
                                    </div>
                                </google-places-autocomplete>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse"
                >
                    <button
                        type="button"
                        class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-orange-200 border border-transparent rounded-md shadow-sm hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm"
                        :disabled="locationSearch.detail === null"
                        @click="$emit('update')"
                    >
                        Update
                    </button>
                    <button
                        type="button"
                        class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                        @click="$emit('show', false)"
                    >
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { GooglePlacesAutocomplete } from "vue-better-google-places-autocomplete";
export default {
    props: ["locationSearch"],
    components: {
        GooglePlacesAutocomplete
    }
};
</script>
