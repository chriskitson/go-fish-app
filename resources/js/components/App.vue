<template>
    <main class="w-full" id="app">
        <header-component></header-component>
        <home-component :venues="venues" :live="live"></home-component>
        <footer-component></footer-component>
    </main>
</template>

<script>
import { mapState } from "vuex";
export default {
    computed: {
        ...mapState({
            venues: state => state.venues,
            live: state => state.live,
            userPosition: state => state.userPosition
        })
    },
    mounted() {
        this.getUserPosition();
    },
    methods: {
        getUserPosition() {
            navigator.geolocation.getCurrentPosition(
                position => {
                    this.$store.dispatch("USER_POSITION", {
                        error: "",
                        ...position.coords
                    });
                    const { coords: { latitude, longitude}} = position;
                    this.getData(`?latitude=${latitude}&longitude=${longitude}`);
                },
                error => {
                    this.$store.dispatch("USER_POSITION", {
                        error,
                        latitude: null,
                        longitude: null
                    });
                    this.getData("");
                }
            );
        },
        getData(q) {
            this.$store.dispatch("BOOTSTRAP_DATA_FETCH", q);
        }
    }
};
</script>
