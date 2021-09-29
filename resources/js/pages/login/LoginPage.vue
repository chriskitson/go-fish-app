<template>
    <div class="w-full max-w-5xl mx-auto">
        <div class="grid grid-cols-2 gap-6 px-4 my-24">
            <login-component
                :login="loginForm"
                :loggedIn="loggedIn"
                @login="login"
            ></login-component>
            <register-component
                :register="registerForm"
                :loggedIn="loggedIn"
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
            loggedIn: state => state.user.loggedIn
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
