<template>
  <div class="w-full h-full max-w-xl mx-auto">
    <div class="grid grid-cols-1 px-4 my-24">
      <signup-component
        v-if="!signupForm.confirmed"
        :register="signupForm"
        :loggedIn="loggedIn"
        :loading="loading"
        @register="register"
      ></signup-component>
      <signupconfirm-component
        v-if="signupForm.confirmed"
      ></signupconfirm-component>
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";
export default {
  computed: {
    ...mapState({
      signupForm: (state) => state.signupForm,
      loggedIn: (state) => state.user.loggedIn,
      loading: (state) => state.loading,
    }),
  },
  methods: {
    register() {
      this.$store.dispatch("SIGNUP", this.$store.state.signupForm);
    },
  },
};
</script>
