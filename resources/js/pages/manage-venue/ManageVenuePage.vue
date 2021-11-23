<template>
    <div class="w-full max-w-5xl px-4 mx-auto">
        <div class="mt-10 mb-20">
            <div class="mb-4" v-if="editMode">
                <h2 class="text-xl font-semibold text-red-200">
                    {{ venue.name }}
                </h2>
            </div>
            <div class="mb-4 md:col-span-2 md:mb-0">
                <manage-tabs-component
                    :tabs="TABS"
                    :active="activeTab"
                    :manageVenueErrorFields="manageVenueErrorFields"
                    @setTab="setTab"
                ></manage-tabs-component>
            </div>
            <manage-details-component
                v-if="activeTab === manageTabs.DETAILS"
                :loading="loading"
                :venue="venue"
                @deleteImage="deleteImage"
                @uploadImage="uploadImage"
            ></manage-details-component>
            <manage-opening-hours-component
                v-if="activeTab === manageTabs.HOURS"
                :venue="venue"
            ></manage-opening-hours-component>
            <manage-payment-component
                v-if="activeTab === manageTabs.PAYMENT"
                :loading="loading"
                :venue="venue"
                :manageVenueErrorFields="manageVenueErrorFields"
            ></manage-payment-component>
            <manage-location-component
                v-if="activeTab === manageTabs.LOCATION"
                :loading="loading"
                :venue="venue"
                :venueSearch="venueSearch"
                :manageVenueErrorFields="manageVenueErrorFields"
            ></manage-location-component>
            <manage-tickets-component
                v-if="activeTab === manageTabs.TICKETS"
                :loading="loading"
                :venue="venue"
                :editMode="editMode"
                :manageVenueNewTicket="manageVenueNewTicket"
                :manageVenueErrorFields="manageVenueErrorFields"
                @addNewTicket="addNewTicket"
                @saveTicket="saveTicket"
                @deleteTicket="deleteTicket"
            ></manage-tickets-component>
            <div
                class="flex items-center justify-end col-span-2 p-4 mb-8 md:mb-0 bg-grey-100"
                v-if="activeTab !== manageTabs.TICKETS"
            >
                <button
                    @click="updateDetails"
                    class="flex items-center justify-center px-3 py-2 ml-2 text-sm text-white bg-orange-200 rounded-lg disabled:opacity-50"
                    :disabled="loading"
                >
                    <icon name="save" class="w-4 h-4 mr-2" />
                    {{ editMode ? "Update details" : "Create Venue" }}
                </button>
            </div>
        </div>
        <page-spinner-component v-if="loading" />
    </div>
</template>

<script>
import { mapState } from "vuex";
import { manageTabs } from "../../store/state";
export default {
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
    data: () => ({
        manageTabs,
        activeTab: 1,
        TABS: [
            {
                index: manageTabs.DETAILS,
                label: "Details"
            },
            {
                index: manageTabs.HOURS,
                label: "Opening Hours"
            },
            {
                index: manageTabs.PAYMENT,
                label: "Payment"
            },
            {
                index: manageTabs.LOCATION,
                label: "Location"
            },
            {
                index: manageTabs.TICKETS,
                label: "Tickets"
            }
        ]
    }),
    methods: {
        setTab(index) {
            this.activeTab = index;
        },
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
