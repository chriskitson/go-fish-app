<template>
  <div class="container flex flex-col items-center flex-1 px-2 mx-auto">
    <login-component
      title="Thank you for signing up to GOFish!"
      description="You may now log in and manage your fishery account."
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
