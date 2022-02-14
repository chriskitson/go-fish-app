<template>
    <div class="w-full max-w-5xl px-4 mx-auto">
        <div class="grid grid-cols-3 gap-6 mt-10 mb-20">
            <div class="col-span-3">
                <venue-booking-list-component
                    :title="`Venue Bookings for ${user.venue.name}`"
                    :tickets="bookings"
                    :live="live"
                ></venue-booking-list-component>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
import { formatDateDisplay } from "../../utils";
export default {
    computed: {
        ...mapState({
            venues: state => state.venues,
            live: state => state.live,
            basket: state => state.basket,
            venueDetail: state => state.venueDetail,
            loggedIn: state => state.user.loggedIn,
            user: state => state.user,
            bookings: state => state.venueBookings
        })
    },
    mounted() {
        this.getBookings(false);
    },
    methods: {
        getBookings(showPast) {
            return this.$store.dispatch("VENUE_BOOKINGS_GET", {
                user: this.user,
                showPast
            });
        }
    }
};
</script>
