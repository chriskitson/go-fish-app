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

      <div
        v-if="signupForm.confirmed"
        class="
          w-full
          px-6
          py-8
          text-black
          bg-white
          rounded
          shadow-md
          bg-opacity-80
        "
      >
        <h1 class="mb-8 text-xl text-center text-red-200">
          Thank you for signing up to GoFish!
        </h1>
        <p class="mb-8 text-center font-semibold">
          Your account needs to be verified by GoFish before you gain access.
        </p>
        <p class="mb-8 text-center">
          Once your account has been verified we will email you.
        </p>
      </div>
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
