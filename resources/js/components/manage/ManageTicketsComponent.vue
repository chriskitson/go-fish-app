<template>
    <div class="mb-8">
        <h3 class="my-8 text-xl font-semibold text-red-200">
            Tickets ({{ venue.tickets.length }})
        </h3>
        <div v-if="!editMode" class="my-4">
            You need to add venue details above and click create venue before
            adding any tickets.
        </div>
        <div
            v-for="(ticket, index) in venue.tickets"
            :key="`ticket-${ticket.id}`"
            :class="`p-2${index % 2 ? ' bg-white' : ' bg-grey-100'}`"
        >
            <div class="mt-10 md:grid md:grid-cols-2 md:gap-6">
                <div class="mb-8 md:mb-0">
                    <label class="block mb-2 font-semibold text-grey-300"
                        >Ticket Name</label
                    >
                    <input
                        type="text"
                        :class="
                            `w-full p-2 mb-5 text-sm border rounded-md b-grey-200 disabled:background-grey-200${
                                ticket.id === 0 &&
                                manageVenueErrorFields.indexOf('name') > -1
                                    ? ' border-red-200'
                                    : ''
                            }`
                        "
                        v-model="ticket.name"
                        :disabled="loading"
                    />
                    <label class="block mb-2 font-semibold text-grey-300"
                        >Ticket Cost</label
                    >
                    <input
                        type="text"
                        :class="
                            `w-full p-2 mb-5 text-sm border rounded-md b-grey-200 disabled:background-grey-200${
                                ticket.id === 0 &&
                                manageVenueErrorFields.indexOf('cost') > -1
                                    ? ' border-red-200'
                                    : ''
                            }`
                        "
                        v-model="ticket.cost"
                        :disabled="loading"
                    />
                    <label class="block mb-2 font-semibold text-grey-300"
                        >Ticket Daily Limit</label
                    >
                    <input
                        type="number"
                        :class="
                            `w-full p-2 mb-5 text-sm border rounded-md b-grey-200 disabled:background-grey-200${
                                ticket.id === 0 &&
                                manageVenueErrorFields.indexOf('daily_limit') >
                                    -1
                                    ? ' border-red-200'
                                    : ''
                            }`
                        "
                        v-model="ticket.daily_limit"
                        :disabled="loading"
                    />
                </div>
                <div class="mb-8 md:mb-0">
                    <label class="block mb-2 font-semibold text-grey-300"
                        >Ticket Description</label
                    >
                    <textarea
                        v-model="ticket.description"
                        :class="
                            `w-full h-56 p-4 text-sm border rounded-md b-grey-200 disabled:background-grey-200${
                                ticket.id === 0 &&
                                manageVenueErrorFields.indexOf('description') >
                                    -1
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
                    @click="$emit('deleteTicket', ticket.id)"
                    v-if="ticket.id > 0"
                    class="flex items-center justify-center px-3 py-2 ml-2 text-sm text-white bg-orange-200 rounded-lg disabled:opacity-50"
                    :disabled="loading"
                >
                    <icon name="trash" class="w-4 h-4 mr-2" />
                    Delete ticket
                </button>
                <button
                    @click="$emit('saveTicket', ticket)"
                    class="flex items-center justify-center px-3 py-2 ml-2 text-sm text-white bg-orange-200 rounded-lg disabled:opacity-50"
                    :disabled="loading"
                >
                    <icon name="save" class="w-4 h-4 mr-2" />
                    Save ticket
                </button>
            </div>
        </div>
        <div class="flex items-center justify-end py-8">
            <button
                @click="$emit('addNewTicket')"
                :disabled="manageVenueNewTicket || loading || !editMode"
                class="flex items-center justify-center px-3 py-2 text-sm text-white bg-red-200 rounded-lg disabled:opacity-50"
            >
                <icon name="plus" class="w-4 h-4 mr-2" />
                Add new ticket
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        "loading",
        "venue",
        "editMode",
        "manageVenueNewTicket",
        "manageVenueErrorFields"
    ],
    methods: {
        errorStyle(key) {
            return this.manageVenueErrorFields?.indexOf(key) > -1
                ? " border-red-200"
                : "";
        }
    }
};
</script>
