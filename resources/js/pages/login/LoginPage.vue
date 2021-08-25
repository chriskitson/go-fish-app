<template>
    <div class="w-full max-w-5xl mx-auto">
        <div class="grid grid-cols-2 gap-6 my-24">
            <login-component
                :login="loginForm"
                @login="login"
            ></login-component>
            <register-component
                :register="registerForm"
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
            registerForm: state => state.registerForm
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
