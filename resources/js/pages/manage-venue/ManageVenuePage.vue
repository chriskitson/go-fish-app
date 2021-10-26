<template>
    <div class="w-full max-w-5xl px-4 mx-auto">
        <div class="grid grid-cols-2 gap-6 mt-10 mb-20">
            <div class="col-span-2">
                <h2 class="text-xl font-semibold text-red-200">
                    {{ venue.name }}
                </h2>
            </div>
            <div>
                <label class="block mb-2 font-semibold text-grey-300"
                    >Description</label
                >
                <textarea
                    v-model="venue.description"
                    class="w-full h-56 p-4 text-sm border rounded-md b-grey-200 disabled:background-grey-200"
                    :disabled="loading"
                ></textarea>
            </div>
            <div>
                <label class="block mb-2 font-semibold text-grey-300"
                    >Rules</label
                >
                <textarea
                    v-model="venue.rules"
                    class="w-full h-56 p-4 text-sm border rounded-md b-grey-200 disabled:background-grey-200"
                    :disabled="loading"
                ></textarea>
            </div>
            <div>
                <label class="block mb-2 font-semibold text-grey-300"
                    >Address</label
                >
                <textarea
                    v-model="venue.address"
                    class="w-full h-32 p-4 text-sm border rounded-md b-grey-200 disabled:background-grey-200"
                    :disabled="loading"
                ></textarea>
            </div>
            <div>
                <label class="block mb-2 font-semibold text-grey-300"
                    >Google Maps Place Id</label
                >
                <input
                    type="text"
                    class="w-full p-2 mb-5 text-sm border rounded-md b-grey-200 disabled:background-grey-200"
                    :disabled="loading"
                    v-model="venue.place_id"
                />
            </div>

            <div class="flex items-center justify-end col-span-2">
                <button
                    @click="updateDetails"
                    class="flex items-center justify-center px-3 py-2 ml-2 text-sm text-white bg-orange-200 rounded-lg disabled:opacity-50"
                    :disabled="loading"
                >
                    <icon name="save" class="w-4 h-4 mr-2" />
                    Update details
                </button>
            </div>

            <div class="col-span-2">
                <hr class="mb-5" />
                <h2 class="text-xl font-semibold text-red-200">
                    Tickets ({{ venue.tickets.length }})
                </h2>
                <div
                    v-for="ticket in venue.tickets"
                    :key="`ticket-${ticket.id}`"
                >
                    <div class="grid grid-cols-2 gap-6 mt-10">
                        <div>
                            <label
                                class="block mb-2 font-semibold text-grey-300"
                                >Ticket Name</label
                            >
                            <input
                                type="text"
                                class="w-full p-2 mb-5 text-sm border rounded-md b-grey-200 disabled:background-grey-200"
                                v-model="ticket.name"
                                :disabled="loading"
                            />
                            <label
                                class="block mb-2 font-semibold text-grey-300"
                                >Ticket Cost</label
                            >
                            <input
                                type="text"
                                class="w-full p-2 mb-5 text-sm border rounded-md b-grey-200 disabled:background-grey-200"
                                v-model="ticket.cost"
                                :disabled="loading"
                            />
                            <label
                                class="block mb-2 font-semibold text-grey-300"
                                >Ticket Daily Limit</label
                            >
                            <input
                                type="number"
                                class="w-full p-2 mb-5 text-sm border rounded-md b-grey-200 disabled:background-grey-200"
                                v-model="ticket.daily_limit"
                                :disabled="loading"
                            />
                        </div>
                        <div>
                            <label
                                class="block mb-2 font-semibold text-grey-300"
                                >Ticket Description</label
                            >
                            <textarea
                                v-model="ticket.description"
                                class="w-full h-56 p-4 text-sm border rounded-md b-grey-200 disabled:background-grey-200"
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
                        :disabled="manageVenueNewTicket || loading"
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
            loading: state => state.loading
        })
    },
    methods: {
        updateDetails() {
            const { user } = this;
            const { id, description, rules, address, place_id } = this.venue;
            const venue = {
                id,
                description,
                rules,
                address,
                place_id
            };
            this.$store.dispatch("VENUE_DETAILS_UPDATE", {
                venue,
                user
            });
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
        }
    }
};
</script>
