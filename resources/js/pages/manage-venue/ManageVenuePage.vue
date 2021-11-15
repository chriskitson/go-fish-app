<template>
    <div class="w-full max-w-5xl px-4 mx-auto">
        <div class="mt-10 mb-20 md:grid md:grid-cols-2 md:gap-6">
            <div class="mb-4 md:col-span-2 md:mb-0" v-if="editMode">
                <h2 class="text-xl font-semibold text-red-200">
                    {{ venue.name }}
                </h2>
            </div>
            <div class="mb-4 md:col-span-2 md:mb-0">
                <h3 class="text-xl font-semibold text-red-200">
                    Details
                </h3>
            </div>
            <div class="mb-8 md:mb-0">
                <label class="block mb-2 font-semibold text-grey-300"
                    >Name</label
                >
                <input
                    type="text"
                    :class="
                        `w-full p-2 mb-5 text-sm border rounded-md b-grey-200 disabled:background-grey-200${errorStyle(
                            'name'
                        )}`
                    "
                    :disabled="loading"
                    v-model="venue.name"
                />
            </div>
            <div class="mb-8 md:mb-0">
                <label class="block mb-2 font-semibold text-grey-300"
                    >Image</label
                >
                <input
                    type="file"
                    accept="image/*"
                    @change="uploadImage($event)"
                    :class="
                        `w-full p-2 mb-5 text-sm border rounded-md b-grey-200 disabled:background-grey-200${errorStyle(
                            'image'
                        )}`
                    "
                    :disabled="loading"
                />
                <img
                    v-if="venue.image"
                    :src="venue.image"
                    :alt="`${venue.name} image`"
                    class="w-full"
                />
                <button
                    @click="deleteImage()"
                    v-if="venue.image"
                    class="flex items-center justify-center px-3 py-2 mt-4 ml-2 text-sm text-white rounded-lg bg-grey-200 disabled:opacity-50"
                    :disabled="loading"
                >
                    <icon name="trash" class="w-4 h-4 mr-2" />
                    Delete image
                </button>
            </div>
            <div class="mb-8 md:mb-0">
                <label class="block mb-2 font-semibold text-grey-300"
                    >Description</label
                >
                <textarea
                    v-model="venue.description"
                    :class="
                        `w-full h-56 p-4 text-sm border rounded-md b-grey-200 disabled:background-grey-200${errorStyle(
                            'description'
                        )}`
                    "
                    :disabled="loading"
                ></textarea>
            </div>
            <div class="mb-8 md:mb-0">
                <label class="block mb-2 font-semibold text-grey-300"
                    >Rules</label
                >
                <textarea
                    v-model="venue.rules"
                    :class="
                        `w-full h-56 p-4 text-sm border rounded-md b-grey-200 disabled:background-grey-200${errorStyle(
                            'rules'
                        )}`
                    "
                    :disabled="loading"
                ></textarea>
            </div>
            <div class="mb-4 md:col-span-2 md:mb-0">
                <hr class="mb-5" />
                <h3 class="text-xl font-semibold text-red-200">
                    Opening Days
                </h3>
            </div>
            <div class="mb-8 md:mb-0 md:col-span-2">
                <div>
                    <label class="inline-flex items-center">
                        <input
                            v-model="venue.days.sunday"
                            type="checkbox"
                            class="form-checkbox"
                        />
                        <span class="ml-2">Sunday</span>
                    </label>
                </div>
                <div>
                    <label class="inline-flex items-center">
                        <input
                            v-model="venue.days.monday"
                            type="checkbox"
                            class="form-checkbox"
                        />
                        <span class="ml-2">Monday</span>
                    </label>
                </div>
                <div>
                    <label class="inline-flex items-center">
                        <input
                            v-model="venue.days.tuesday"
                            type="checkbox"
                            class="form-checkbox"
                        />
                        <span class="ml-2">Tuesday</span>
                    </label>
                </div>
                <div>
                    <label class="inline-flex items-center">
                        <input
                            v-model="venue.days.wednesday"
                            type="checkbox"
                            class="form-checkbox"
                        />
                        <span class="ml-2">Wednesday</span>
                    </label>
                </div>
                <div>
                    <label class="inline-flex items-center">
                        <input
                            v-model="venue.days.thursday"
                            type="checkbox"
                            class="form-checkbox"
                        />
                        <span class="ml-2">Thursday</span>
                    </label>
                </div>
                <div>
                    <label class="inline-flex items-center">
                        <input
                            v-model="venue.days.friday"
                            type="checkbox"
                            class="form-checkbox"
                        />
                        <span class="ml-2">Friday</span>
                    </label>
                </div>
                <div>
                    <label class="inline-flex items-center">
                        <input
                            v-model="venue.days.saturday"
                            type="checkbox"
                            class="form-checkbox"
                        />
                        <span class="ml-2">Saturday</span>
                    </label>
                </div>
            </div>

            <div class="mb-4 md:col-span-2 md:mb-0">
                <hr class="mb-5" />
                <h3 class="text-xl font-semibold text-red-200">
                    Payment
                </h3>
            </div>
            <div class="mb-8 md:mb-0">
                <label class="block mb-2 font-semibold text-grey-300"
                    >Stripe Account</label
                >
                <input
                    type="text"
                    :class="
                        `w-full p-2 mb-5 text-sm border rounded-md b-grey-200 disabled:background-grey-200${errorStyle(
                            'account'
                        )}`
                    "
                    :disabled="loading"
                    v-model="venue.account"
                />
            </div>
            <div class="mb-4 md:col-span-2 md:mb-0">
                <hr class="mb-5" />
                <h3 class="text-xl font-semibold text-red-200">
                    Location
                </h3>
            </div>
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
                            @keydown.down.prevent="
                                actions.shiftResultsSelection
                            "
                            @keydown.up.prevent="
                                actions.unshiftResultsSelection
                            "
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

            <div class="flex items-center justify-end col-span-2 mb-8 md:mb-0">
                <button
                    @click="updateDetails"
                    class="flex items-center justify-center px-3 py-2 ml-2 text-sm text-white bg-orange-200 rounded-lg disabled:opacity-50"
                    :disabled="loading"
                >
                    <icon name="save" class="w-4 h-4 mr-2" />
                    {{ editMode ? "Update details" : "Create Venue" }}
                </button>
            </div>

            <div class="md:col-span-2">
                <hr class="mb-5" />
                <h2 class="text-xl font-semibold text-red-200">
                    Tickets ({{ venue.tickets.length }})
                </h2>
                <div v-if="!editMode" class="my-4">
                    You need to add venue details above and click create venue
                    before adding any tickets.
                </div>
                <div
                    v-for="ticket in venue.tickets"
                    :key="`ticket-${ticket.id}`"
                >
                    <div class="mt-10 md:grid md:grid-cols-2 md:gap-6">
                        <div class="mb-8 md:mb-0">
                            <label
                                class="block mb-2 font-semibold text-grey-300"
                                >Ticket Name</label
                            >
                            <input
                                type="text"
                                :class="
                                    `w-full p-2 mb-5 text-sm border rounded-md b-grey-200 disabled:background-grey-200${
                                        ticket.id === 0 &&
                                        manageVenueErrorFields.indexOf('name') >
                                            -1
                                            ? ' border-red-200'
                                            : ''
                                    }`
                                "
                                v-model="ticket.name"
                                :disabled="loading"
                            />
                            <label
                                class="block mb-2 font-semibold text-grey-300"
                                >Ticket Cost</label
                            >
                            <input
                                type="text"
                                :class="
                                    `w-full p-2 mb-5 text-sm border rounded-md b-grey-200 disabled:background-grey-200${
                                        ticket.id === 0 &&
                                        manageVenueErrorFields.indexOf('cost') >
                                            -1
                                            ? ' border-red-200'
                                            : ''
                                    }`
                                "
                                v-model="ticket.cost"
                                :disabled="loading"
                            />
                            <label
                                class="block mb-2 font-semibold text-grey-300"
                                >Ticket Daily Limit</label
                            >
                            <input
                                type="number"
                                :class="
                                    `w-full p-2 mb-5 text-sm border rounded-md b-grey-200 disabled:background-grey-200${
                                        ticket.id === 0 &&
                                        manageVenueErrorFields.indexOf(
                                            'daily_limit'
                                        ) > -1
                                            ? ' border-red-200'
                                            : ''
                                    }`
                                "
                                v-model="ticket.daily_limit"
                                :disabled="loading"
                            />
                        </div>
                        <div class="mb-8 md:mb-0">
                            <label
                                class="block mb-2 font-semibold text-grey-300"
                                >Ticket Description</label
                            >
                            <textarea
                                v-model="ticket.description"
                                :class="
                                    `w-full h-56 p-4 text-sm border rounded-md b-grey-200 disabled:background-grey-200${
                                        ticket.id === 0 &&
                                        manageVenueErrorFields.indexOf(
                                            'description'
                                        ) > -1
                                            ? ' border-red-200'
                                            : ''
                                    }`
                                "
                                :disabled="loading"
                            ></textarea>
                        </div>
                    </div>
                    <div class="flex items-center justify-end">
                        <button
                            @click="deleteTicket(ticket.id)"
                            v-if="ticket.id > 0"
                            class="flex items-center justify-center px-3 py-2 ml-2 text-sm text-white bg-orange-200 rounded-lg disabled:opacity-50"
                            :disabled="loading"
                        >
                            <icon name="trash" class="w-4 h-4 mr-2" />
                            Delete ticket
                        </button>
                        <button
                            @click="saveTicket(ticket)"
                            class="flex items-center justify-center px-3 py-2 ml-2 text-sm text-white bg-orange-200 rounded-lg disabled:opacity-50"
                            :disabled="loading"
                        >
                            <icon name="save" class="w-4 h-4 mr-2" />
                            Save ticket
                        </button>
                    </div>
                    <hr class="my-5" />
                </div>
                <div class="flex items-center justify-end">
                    <button
                        @click="addNewTicket"
                        :disabled="manageVenueNewTicket || loading || !editMode"
                        class="flex items-center justify-center px-3 py-2 text-sm text-white bg-red-200 rounded-lg disabled:opacity-50"
                    >
                        <icon name="plus" class="w-4 h-4 mr-2" />
                        Add new ticket
                    </button>
                </div>
            </div>
        </div>
        <page-spinner-component v-if="loading" />
    </div>
</template>

<script>
import { mapState } from "vuex";
import { GooglePlacesAutocomplete } from "vue-better-google-places-autocomplete";
export default {
    components: {
        GooglePlacesAutocomplete
    },
    computed: {
        ...mapState({
            venue: state => state.venueDetail,
            live: state => state.live,
            basket: state => state.basket,
            venueDetail: state => state.venueDetail,
            loggedIn: state => state.user.loggedIn,
            user: state => state.user,
            manageVenueNewTicket: state => state.manageVenueNewTicket,
            loading: state => state.loading,
            manageVenueErrorFields: state => state.manageVenueErrorFields,
            editMode: state => state.venueDetail?.id > 0,
            venueSearch: state => state.venueSearch
        })
    },
    methods: {
        errorStyle(key) {
            return this.manageVenueErrorFields.indexOf(key) > -1
                ? " border-red-200"
                : "";
        },
        findVenue({ place_id, formatted_address }) {
            this.venue.place_id = place_id;
            this.venue.address = formatted_address;
        },
        updateDetails() {
            const { user } = this;
            const {
                id,
                description,
                rules,
                account,
                address,
                place_id,
                name,
                image,
                days
            } = this.venue;
            if (id > 0) {
                // update
                const venue = {
                    id,
                    name,
                    description,
                    rules,
                    address,
                    account,
                    place_id,
                    open_sunday: days.sunday,
                    open_monday: days.monday,
                    open_tuesday: days.tuesday,
                    open_wednesday: days.wednesday,
                    open_thursday: days.thursday,
                    open_friday: days.friday,
                    open_saturday: days.saturday
                };
                this.$store.dispatch("VENUE_DETAILS_UPDATE", {
                    venue,
                    user
                });
            } else {
                // create
                const venue = {
                    name,
                    description,
                    account,
                    rules,
                    address,
                    place_id,
                    image,
                    open_sunday: days.sunday,
                    open_monday: days.monday,
                    open_tuesday: days.tuesday,
                    open_wednesday: days.wednesday,
                    open_thursday: days.thursday,
                    open_friday: days.friday,
                    open_saturday: days.saturday
                };
                this.$store.dispatch("VENUE_DETAILS_CREATE", {
                    venue,
                    user
                });
            }
        },
        addNewTicket() {
            this.$store.dispatch("VENUE_TICKET_ADD");
        },
        saveTicket(details) {
            const { user } = this;
            const { id, name, description, cost, daily_limit } = details;
            const ticket = {
                id,
                name,
                description,
                cost,
                daily_limit
            };
            this.$store.dispatch("VENUE_TICKET_SAVE", {
                venue_id: this.venue.id,
                ticket,
                user
            });
        },
        deleteTicket(id) {
            const { user } = this;
            this.$store.dispatch("VENUE_TICKET_DELETE", {
                venue_id: this.venue.id,
                id,
                user
            });
        },
        uploadImage(event) {
            const { user } = this;
            const image = event.target.files[0];
            this.$store.dispatch("VENUE_IMAGE_UPLOAD", {
                venue_id: this.venue.id,
                image,
                user
            });
        },
        deleteImage() {
            const { user } = this;
            this.$store.dispatch("VENUE_IMAGE_DELETE", {
                venue_id: this.venue.id,
                user
            });
        }
    }
};
</script>
