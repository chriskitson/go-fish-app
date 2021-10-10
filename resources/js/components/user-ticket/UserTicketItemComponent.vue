<template>
    <div class="flex flex-col w-full">
        <div
            class="flex flex-col items-center w-full px-2 py-2 border md:py-0 md:h-12 justify-items bg-grey-300 border-grey-300 md:flex-row"
            v-if="live"
        >
            <icon
                name="ticket"
                class="mr-2 text-lg text-white w-7 h-7"
                v-if="live"
            />
            <span class="flex-grow font-semibold text-center text-white md:text-left">
                {{
                    live
                        ? `${formatDateDisplay(ticket.ticket_date)} - ${
                              ticket.venue_name
                          } - ${ticket.ticket_name}`
                        : "&nbsp;"
                }}
            </span>
            <span
                class="px-3 py-1 mt-4 text-lg font-semibold text-white bg-orange-200 rounded-full md:mt-0"
            >
                {{ formatCurrency(ticket.cost) }}
            </span>
        </div>
        <div
            class="p-4 text-sm text-white border-b border-l border-r border-grey-300 text-grey-300"
            v-if="live"
        >
            <div class="flex flex-col">
                <div class="grid grid-cols-2 gap-6 mb-2 md:grid-cols-6">
                    <div class="font-semibold">Transaction Date</div>
                    <div class="md:col-span-4">
                        {{ formatDateTimeDisplay(ticket.transaction_date) }}
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6 mb-2 md:grid-cols-6">
                    <div class="font-semibold">Ticket Cost</div>
                    <div class="md:col-span-4">
                        {{ formatCurrency(ticket.cost) }}
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6 mb-2 md:grid-cols-6">
                    <div class="font-semibold">Venue</div>
                    <div class="md:col-span-4"><a :href="`/venue/${ticket.venue_id}`" class="text-red-200">{{ ticket.venue_name }}</a></div>
                </div>
                <div class="grid grid-cols-2 gap-6 mb-2 md:grid-cols-6">
                    <div class="font-semibold">Ticket Date</div>
                    <div class="md:col-span-4">
                        {{ formatDateDisplay(ticket.ticket_date) }}
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6 mb-2 md:grid-cols-6">
                    <div class="font-semibold">Ticket Type</div>
                    <div class="md:col-span-4">{{ ticket.ticket_name }}</div>
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
    formatDateTimeDisplay
} from "../../utils";
export default {
    props: ["ticket", "live"],
    data: () => ({
        formatCurrency,
        formatDateDisplay,
        formatDateTimeDisplay
    })
};
</script>
