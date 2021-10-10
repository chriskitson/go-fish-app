<template>
    <div class="w-full max-w-5xl mx-auto">
        <div class="grid grid-cols-4 gap-6 mt-10 mb-20">
            <div class="hidden col-span-4 md:block md:col-span-1">
                &nbsp;
            </div>
            <div class="col-span-4 md:col-span-3">
                <basket-list-component
                    :basketTotal="basketTotal"
                    :items="basket"
                    :live="live"
                    :auth="false"
                    :loggedIn="loggedIn"
                    :bookingFee="bookingFee"
                    display="4"
                    @checkout="checkout"
                    @remove="removeTicket"
                    @up="upTicket"
                    @down="downTicket"
                ></basket-list-component>
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
            loggedIn: state => state.user.loggedIn,
            basket: state => state.basket,
            basketTotal: state =>
                state.basket
                    .map(b => b.basket_qty * b.ticket_cost)
                    .reduce((a, b) => a + b, 0),
            bookingFee: state =>
                state.basket
                    .map(b => b.basket_qty * state.bookingFee)
                    .reduce((a, b) => a + b, 0)
        })
    },
    mounted() {},
    methods: {
        checkout() {
            this.$store.dispatch("BOOK", {
                user: this.user,
                url: this.$route.fullPath
            });
        },
        removeTicket({ id }) {
            this.$store.dispatch("BASKET_REMOVE", { id, user: this.user });
        },
        upTicket({ id }) {
            this.$store.dispatch("BASKET_QTY", {
                direction: "up",
                id,
                user: this.user
            });
        },
        downTicket({ id }) {
            this.$store.dispatch("BASKET_QTY", {
                direction: "down",
                id,
                user: this.user
            });
        }
    }
};
</script>
