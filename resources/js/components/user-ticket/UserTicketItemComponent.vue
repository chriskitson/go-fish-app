<template>
    <div class="flex flex-col w-full">
        <div
            class="flex flex-col items-center w-full px-2 py-2 border md:py-0 md:h-12 justify-items bg-grey-300 border-grey-300 md:flex-row"
            v-if="live"
        >
            <icon name="ticket" class="mr-2 text-lg text-white w-7 h-7" />
            <span
                class="flex-grow font-semibold text-center text-white md:text-left"
            >
                {{ padNumber(ticket.id, 5) }}
                &nbsp;-&nbsp;
                {{ ticket.tickets.length > 0 ? ticket.tickets[0].venue_name : "Unknown" }}
            </span>
            <span
                class="px-3 py-1 mt-4 text-lg font-semibold text-white bg-orange-200 rounded-full md:mt-0"
            >
                {{ ticket.qty }}
            </span>
        </div>
        <div
            class="p-4 text-sm text-white border-b border-l border-r border-grey-300 text-grey-300"
            v-if="live"
        >
            <div class="flex flex-col">
                <div class="grid grid-cols-2 gap-6 mb-2 md:grid-cols-6">
                    <div class="font-semibold">Booking date</div>
                    <div class="md:col-span-4">
                    {{ formatDateDisplay(ticket.date) }}
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6 mb-2 md:grid-cols-6">
                    <div class="font-semibold">Ticket(s)</div>
                    <div class="md:col-span-4">
                        <div v-for="t in ticket.tickets" :key="`user-ticket-${t.id}`">
                            {{ t.ticket_name }} - {{ formatCurrency(t.booking_cost) }}
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6 mb-2 md:grid-cols-6">
                    <div class="font-semibold">Booking cost</div>
                    <div class="flex items-center md:col-span-4">
                        {{ formatCurrency(ticket.total) }} <em> (inc. {{ formatCurrency(ticket.booking_fee) }} booking fee)</em>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6 mb-2 md:grid-cols-6">
                    <div class="font-semibold"></div>
                    <div class="md:col-span-4">
                        <a
                            :href="`/confirm/${ticket.session}`"
                            v-if="ticket.session && ticket.session !== ''"
                            class="flex items-center text-sm text-orange-200"
                        >
                            <icon
                                name="check-circle"
                                class="w-5 h-5 mr-1 text-lg"
                            />
                            View Confirmation
                        </a>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6 mb-2 md:grid-cols-6">
                    <div class="font-semibold"></div>
                    <div class="md:col-span-4">
                        <a
                            :href="ticket.receipt_link"
                            target="_blank"
                            v-if="
                                ticket.receipt_link &&
                                    ticket.receipt_link !== ''
                            "
                            class="flex items-center text-sm text-orange-200"
                        >
                            <icon
                                name="receipt-tax"
                                class="w-5 h-5 mr-1 text-lg"
                            />
                            View Receipt
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="border h-44 bg-grey-200 border-grey-200 bg-opacity-10"
            v-if="!live"
        >
            &nbsp;
        </div>
    </div>
</template>

<script>
import {
    formatCurrency,
    formatDateDisplay,
    formatDateTimeDisplay,
    padNumber
} from "../../utils";
export default {
    props: ["ticket", "live"],
    data: () => ({
        formatCurrency,
        formatDateDisplay,
        formatDateTimeDisplay,
        padNumber
    })
};
</script>
x
