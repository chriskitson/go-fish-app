<template>
    <div class="w-full max-w-5xl mb-10">
        <h2 class="flex items-center mb-4 text-xl font-semibold text-grey-300">
            {{ live ? title : "Tickets loading..." }}
        </h2>
        <div
            class="flex flex-wrap items-center w-full space-y-4 py-50"
            v-if="live && tickets.length > 0"
        >
            <venue-booking-item-component
                v-for="(ticket, i) in tickets"
                :key="`user-ticket-${i}`"
                :live="live"
                :ticket="ticket"
            ></venue-booking-item-component>
        </div>
        <div v-if="live && tickets.length === 0">
            {{ MESSAGES.TICKETS.None }}
        </div>
        <div
            class="flex flex-wrap items-center w-full space-y-4 py-50"
            v-if="!live"
        >
            <venue-booking-item-component
                :live="live"
            ></venue-booking-item-component>
            <venue-booking-item-component
                :live="live"
            ></venue-booking-item-component>
            <venue-booking-item-component
                :live="live"
            ></venue-booking-item-component>
            <venue-booking-item-component
                :live="live"
            ></venue-booking-item-component>
        </div>
    </div>
</template>

<script>
import { MESSAGES } from "../../config/messages";
export default {
    props: ["title", "tickets", "live"],
    data: () => ({
        MESSAGES
    })
};
</script>
