<template>
    <div class="w-full max-w-5xl px-4 mx-auto">
        <div v-if="live">
            <h1 class="mt-16 mb-4 text-xl font-semibold text-red-200">
                You're ready to GoFish at {{ venue }}!
            </h1>
            <p class="mb-2">
                Thank you for your order. Your order reference is
                <strong>{{ padNumber(ticket.id, 5) }}</strong
                >.
            </p>
            <p class="mb-4">
                Your payment method has been charged
                <strong>{{ formatCurrency(ticket.total) }}</strong> including a
                booking fee of {{ formatCurrency(ticket.booking_fee) }}.
            </p>
            <p class="mb-4">
                <a
                    :href="ticket.receipt_link"
                    target="_blank"
                    v-if="ticket.receipt_link && ticket.receipt_link !== ''"
                    class="flex items-center text-red-200"
                >
                    <icon
                        name="receipt-tax"
                        class="w-5 h-5 mr-1 text-lg hover:underline"
                    />
                    View Receipt
                </a>
            </p>
            <h3 class="mt-8 mb-4 text-lg font-semibold text-red-200">
                Your Tickets
            </h3>
            <div
                :class="
                    `grid w-full grid-cols-6 p-2 ${
                        index % 2 ? ' bg-white' : ' bg-grey-100'
                    }`
                "
                v-for="(t, index) in ticket.tickets"
                :key="`live-${t.booking_id}`"
            >
                <div>
                    {{ padNumber(t.booking_id, 8) }}
                </div>
                <div>
                    <a
                        :href="`/venue/${t.venue_id}`"
                        class="text-orange-200 hover:underline"
                        >{{ t.venue_name }}</a
                    >
                </div>
                <div>
                    {{ t.ticket_name }}
                </div>
                <div>
                    {{ formatDateDisplay(parseISO(t.booking_date)) }}
                </div>
                <div>
                    {{ formatCurrency(t.booking_cost) }}
                </div>
            </div>
            <p class="mt-8">
                <a href="/tickets" class="text-red-200 hover:underline"
                    >View All My Tickets</a
                >
            </p>
        </div>
        <div v-if="!live">
            <h1 class="mt-16 mb-4 text-xl font-semibold text-red-200 h-96">
                Loading...
            </h1>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
import {
    formatCurrency,
    formatDateDisplay,
    formatDateTimeDisplay,
    padNumber
} from "../../utils";
import { parseISO } from "date-fns";
export default {
    computed: {
        ...mapState({
            venues: state => state.venues,
            live: state => state.live,
            user: state => state.user,
            ticket: state => state.userTicketDetail,
            venue: state =>
                state.userTicketDetail.tickets?.length > 0
                    ? state.userTicketDetail.tickets[0].venue_name
                    : ""
        })
    },
    mounted() {
        if (this.$route?.params?.id !== "") {
            this.getMyTicket(this.$route.params.id);
        }
    },
    methods: {
        getMyTicket(session) {
            return this.$store.dispatch("MY_TICKET_GET", {
                user: this.user,
                session
            });
        }
    },
    data: () => ({
        formatCurrency,
        formatDateDisplay,
        formatDateTimeDisplay,
        padNumber,
        parseISO
    })
};
</script>
