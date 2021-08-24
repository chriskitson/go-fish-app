<template>
    <div class="w-full max-w-5xl mb-10">
        <h2 class="flex items-center mb-4 text-xl font-semibold">
            {{ title }}
        </h2>
        <div
            class="flex flex-wrap items-center w-full space-y-4 py-50"
            v-if="live"
        >
            <ticket-item-component
                v-for="(ticket) in tickets"
                :key="`live-${ticket.id}`"
                :live="live"
                :ticket="ticket"
                :display="display"
                @book="$emit('book', $event)"
            ></ticket-item-component>
            <ticket-item-component
                v-for="index in tickets.length < display ? display - tickets.length : 0"
                :key="`empty-${index}`"
                :live="false"
                :display="display"
            ></ticket-item-component>
        </div>
        <div
            class="flex items-center justify-between w-full mx-auto space-x-4 py-50"
            v-if="!live"
        >
            <ticket-item-component :live="live" :display="display"></ticket-item-component>
            <ticket-item-component :live="live" :display="display"></ticket-item-component>
            <ticket-item-component :live="live" :display="display"></ticket-item-component>
            <ticket-item-component :live="live" :display="display"></ticket-item-component>
        </div>
    </div>
</template>

<script>
export default {
    props: ["title", "tickets", "live", "display" ]
};
</script>
