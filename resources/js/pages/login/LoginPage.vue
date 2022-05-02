<template>
    <div class="w-full h-full max-w-5xl mx-auto">
        <div class="grid grid-cols-1 gap-6 px-4 my-24 lg:grid-cols-2">
            <login-component
                title="Existing users login to GoFish!"
                :login="loginForm"
                :loggedIn="loggedIn"
                :loading="loading"
                @login="login"
            ></login-component>
            <register-component
                :register="registerForm"
                :loggedIn="loggedIn"
                :loading="loading"
                @register="register"
            ></register-component>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
export default {
    computed: {
        ...mapState({
            loginForm: state => state.loginForm,
            registerForm: state => state.registerForm,
            loggedIn: state => state.user.loggedIn,
            loading: state => state.loading
        })
    },
    methods: {
        login() {
            this.$store.dispatch("LOGIN", this.$store.state.loginForm);
        },
        register() {
            this.$store.dispatch("REGISTER", this.$store.state.registerForm);
        }
    }
};
</script>
