<template>
    <div class="w-full max-w-5xl mx-auto">
        <div class="grid grid-cols-3 gap-6 mt-10 mb-20">
            <div>
                &nbsp;
            </div>
            <div class="col-span-2">
                <h1 class="mb-3 text-xl font-semibold">Basket</h1>
                <basket-list-component
                    :title="ticketTitle"
                    :items="basket"
                    :live="true"
                    :auth="false"
                    :loggedIn="loggedIn"
                    display="4"
                    @book="bookTickets"
                ></basket-list-component>
                <basket-item-component
                    v-if="basket.length === 0"
                    :live="live"
                    :display="true"
                ></basket-item-component>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
export default {
    computed: {
        ...mapState({
            live: state => state.live,
            user: state => state.user,
            basket: state => state.basket
        })
    },
    mounted() {

    },
    methods: {
        // bookTickets(data) {
        //     const { date, venue_id, ticket_id } = this.$route.params;
        //     return this.$store.dispatch("TICKET_BOOK", {
        //         ticket_id,
        //         venue_id,
        //         date,
        //         user: this.user,
        //         url: this.$route.fullPath
        //     });
        // }
    }
};
</script>
