<template>
    <div class="w-full max-w-5xl px-4 mx-auto">
        <div class="grid grid-cols-3 gap-6 mt-10 mb-20">
            <div class="col-span-3">
                <user-ticket-list-component
                    title="My Tickets"
                    :tickets="userTickets"
                    :live="live"
                ></user-ticket-list-component>
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
            userTickets: state => state.userTickets
        })
    },
    mounted() {
        this.getMyTickets();
    },
    methods: {
        getMyTickets() {
            return this.$store.dispatch("MY_TICKETS_GET", {
                user: this.user
            });
        }
    }
};
</script>
