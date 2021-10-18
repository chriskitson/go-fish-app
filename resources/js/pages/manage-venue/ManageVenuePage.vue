<template>
    <div class="w-full max-w-5xl px-4 mx-auto">
        <div class="grid grid-cols-2 gap-6 mt-10 mb-20">
            <div class="col-span-2">
                <h2 class="text-xl font-semibold text-grey-300">
                    {{ venue.name }}
                </h2>
            </div>
            <div>
                <label class="block mb-2 font-semibold text-grey-300"
                    >Description</label
                >
                <textarea
                    :value="venue.description"
                    class="w-full h-56 p-4 text-sm border rounded-md b-grey-200"
                ></textarea>
            </div>
            <div>
                <label class="block mb-2 font-semibold text-grey-300"
                    >Rules</label
                >
                <textarea
                    :value="venue.rules"
                    class="w-full h-56 p-4 text-sm border rounded-md b-grey-200"
                ></textarea>
            </div>
            <div>
                <label class="block mb-2 font-semibold text-grey-300"
                    >Address</label
                >
                <textarea
                    :value="venue.address"
                    class="w-full h-32 p-4 text-sm border rounded-md b-grey-200"
                ></textarea>
            </div>
            <div>
                <label class="block mb-2 font-semibold text-grey-300"
                    >Google Maps Place Id</label
                >
                <input
                    type="text"
                    class="w-full p-2 mb-5 text-sm border rounded-md b-grey-200"
                    :value="venue.place_id"
                />
            </div>
            <div class="col-span-2">
                <hr class="mb-5" />
                <h2 class="text-xl font-semibold text-grey-300">
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
                                class="w-full p-2 mb-5 text-sm border rounded-md b-grey-200"
                                :value="ticket.name"
                            />
                            <label
                                class="block mb-2 font-semibold text-grey-300"
                                >Ticket Cost</label
                            >
                            <input
                                type="text"
                                class="w-full p-2 mb-5 text-sm border rounded-md b-grey-200"
                                :value="ticket.cost"
                            />
                            <label
                                class="block mb-2 font-semibold text-grey-300"
                                >Ticket Daily Limit</label
                            >
                            <input
                                type="number"
                                class="w-full p-2 mb-5 text-sm border rounded-md b-grey-200"
                                :value="ticket.daily_limit"
                            />
                        </div>
                        <div>
                            <label
                                class="block mb-2 font-semibold text-grey-300"
                                >Ticket Description</label
                            >
                            <textarea
                                :value="ticket.description"
                                class="w-full h-56 p-4 text-sm border rounded-md b-grey-200"
                            ></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
            user: state => state.user
        })
    }
};
</script>
