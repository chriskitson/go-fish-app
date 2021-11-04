<template>
    <div class="w-full max-w-5xl px-4 mx-auto">
        <div class="grid grid-cols-3 gap-6 mt-10 mb-20">
            <div class="col-span-3">
                <div class="flex justify-end w-full">
                    <a
                        href="/add-venue"
                        class="flex items-center justify-center px-3 py-2 my-4 text-sm text-white bg-red-200 rounded-lg disabled:opacity-50"
                    >
                        <icon name="plus" class="w-4 h-4 mr-2" />
                        Add Venue
                    </a>
                </div>
                <ul>
                    <li v-for="venue in venues" :key="venue.id" class="flex items-center justify-center p-2 mb-4">
                        <a
                            :href="`/manage-venues/${venue.id}`"
                            class="flex-1 text-red-200 hover:underline"
                            >{{ venue.name }}</a
                        >
                        <button
                            @click="deleteVenue(venue.id)"
                            class="flex items-center justify-center px-3 py-2 text-sm text-white rounded-lg bg-grey-200 disabled:opacity-50"
                        >
                            <icon name="trash" class="w-4 h-4" />
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
export default {
    computed: {
        ...mapState({
            venues: state => state.manageVenues,
            live: state => state.live,
            basket: state => state.basket,
            venueDetail: state => state.venueDetail,
            loggedIn: state => state.user.loggedIn,
            user: state => state.user,
            userTickets: state => state.userTickets
        })
    },
    methods: {
        deleteVenue(id) {
            const { user } = this;
            this.$store.dispatch("VENUE_DELETE", {
                id,
                user
            });
        }
    }
};
</script>
