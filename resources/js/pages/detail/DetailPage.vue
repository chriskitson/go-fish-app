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
                <ticket-list-component
                    :title="ticketTitle"
                    :tickets="venueDetail.tickets"
                    :live="venueDetail.ticketsLoaded"
                    :auth="false"
                    :loggedIn="loggedIn"
                    display="4"
                    @book="bookTickets"
                ></ticket-list-component>
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
            loggedIn: state => state.user.loggedIn,
            user: state => state.user,
            dateSearch: state => state.dateSearch,
            ticketTitle: state =>
                state.venueDetail.tickets.length > 0
                    ? `Tickets from £${
                          state.venueDetail.tickets.sort(
                              (a, b) => a.cost - b.cost
                          )[0].cost
                      }`
                    : "No tickets available"
        })
    },
    mounted() {
        this.getVenueTickets(
            this.$store.state.venueDetail.id,
            this.$store.state.dateSearch
        );
    },
    methods: {
        getVenueTickets(id, date) {
            return this.$store.dispatch("VENUE_TICKETS_GET", {
                id,
                date,
                user: this.user
            });
        },
        bookTickets(data) {
            const { ticket_id, venue_id } = data;
            const date = this.dateSearch;
            if (!this.loggedIn) {
                localStorage.setItem("referrer", `/book/${date}/${venue_id}/${ticket_id}`);
            }
            window.location.href = this.loggedIn
                ? `/book/${date}/${venue_id}/${ticket_id}`
                : `/login`;
        }
    }
};
</script>
