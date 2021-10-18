<template>
    <div class="w-full max-w-5xl px-4 mx-auto">
        <div class="grid grid-cols-3 gap-6 mt-10 mb-20">
            <div class="col-span-3">
                <ul>
                    <li v-for="venue in venues" :key="venue.id">
                        <a :href="`/manage-venues/${venue.id}`" class="text-red-200 hover:underline">{{
                            venue.name
                        }}</a>
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
    }
};
</script>
