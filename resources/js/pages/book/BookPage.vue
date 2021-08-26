<template>
    <div class="w-full max-w-5xl mx-auto">
        <div class="grid grid-cols-3 gap-6 mt-10 mb-20">
            <div>
                <img
                    src="/images/river.jpg"
                    class="w-full mb-5 rounded-md"
                    alt=""
                />
                <h1 class="text-xl font-semibold">{{ venueDetail.name }}</h1>
                <p class="mb-10 text-sm font-semibold">
                    {{ venueDetail.address }}
                </p>
                <p class="text-sm">{{ venueDetail.description }}</p>
                <div class="flex mt-5">
                    <button
                        class="flex items-center justify-center px-3 py-1 mr-2 text-sm text-white rounded-lg bg-primary"
                    >
                        <icon name="location-marker" class="w-4 h-4 mr-2" />
                        Directions
                    </button>
                    <button
                        class="flex items-center justify-center px-3 py-2 text-sm text-white rounded-lg bg-primary"
                    >
                        <icon name="pencil" class="w-4 h-4 mr-2" />
                        Review
                    </button>
                </div>
                <div class="p-5 mt-10 border border-light text-dark">
                    <h2 class="mb-2 font-semibold">Rules</h2>
                    <ul>
                        <li class="text-sm">Example rule</li>
                        <li class="text-sm">Example rule</li>
                        <li class="text-sm">Example rule</li>
                    </ul>
                </div>
            </div>
            <div class="col-span-2">
                <h1 class="mb-3 text-xl font-semibold">Book now</h1>
                <ticket-item-component
                    v-if="tickets.length > 0"
                    :live="live"
                    :ticket="tickets[0]"
                    :display="true"
                    :auth="true"
                    :loggedIn="user.loggedIn"
                    @book="bookTickets"
                ></ticket-item-component>
                <ticket-item-component
                    v-if="tickets.length === 0"
                    :live="live"
                    :display="true"
                ></ticket-item-component>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
export default {
    computed: {
        ...mapState({
            venues: state => state.venues,
            live: state => state.live,
            venueDetail: state => state.venueDetail,
            tickets: state => state.venueDetail.tickets,
            user: state => state.user
        })
    },
    mounted() {
        const { date, venue_id, ticket_id } = this.$route.params;
        this.getVenueTicket(venue_id, ticket_id, date);
    },
    methods: {
        getVenueTicket(venue_id, id, date) {
            return this.$store.dispatch("VENUE_TICKET_GET", {
                venue_id,
                id,
                date,
                user: this.user
            });
        },
        bookTickets(data) {
            const { date, venue_id, ticket_id } = this.$route.params;
            return this.$store.dispatch("TICKET_BOOK", {
                ticket_id,
                venue_id,
                date,
                user: this.user
            });
        }
    }
};
</script>
