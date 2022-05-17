<template>
  <div class="container flex flex-col items-center flex-1 px-2 mx-auto">
    <login-component
      title="Thank you for signing up to GoFish!"
      description="Your account needs to be verified by GoFish before you have access. Once your account has been verified we will email you."
      :login="loginForm"
      :loggedIn="loggedIn"
      :loading="loading"
      @login="login"
    ></login-component>
  </div>
</template>

<script>
import { mapState } from "vuex";
export default {
  computed: {
    ...mapState({
      loginForm: (state) => state.loginForm,
      loggedIn: (state) => state.user.loggedIn,
      loading: (state) => state.loading,
    }),
  },
  methods: {
    login() {
      this.$store.dispatch("LOGIN", this.$store.state.loginForm);
    },
  },
};
</script>
