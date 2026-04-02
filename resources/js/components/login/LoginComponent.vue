<template>
  <div class="container flex flex-col items-center flex-1 px-2 mx-auto">
    <div
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
        {{ title }}
      </h1>
      <p class="mb-8 text-center" v-if="description !== ''">{{ description }}</p>
      <alert-component
        v-if="login.errors.length > 0"
        :message="login.errors.join(', ')"
        type="error"
      ></alert-component>
      <alert-component
        v-if="login.messages.length > 0"
        :message="login.messages.join(', ')"
        type="success"
      ></alert-component>
      <input
        type="text"
        class="block w-full p-3 mb-4 text-sm border rounded border-grey-100"
        name="email"
        placeholder="Email"
        v-model="login.email"
      />
      <input
        type="password"
        class="block w-full p-3 mb-4 text-sm border rounded border-grey-100"
        name="password"
        placeholder="Password"
        v-model="login.password"
      />
      <button
        type="submit"
        :disabled="loading || loggedIn"
        class="
          flex
          items-center
          w-full
          p-3
          my-1
          text-sm text-center text-white
          bg-red-200
          rounded
          focus:outline-none
          justify-items-center
          disabled:opacity-50
        "
        @click="$emit('login')"
      >
        <div
          v-if="loading"
          :class="`border-t-4 border-b-3 rounded-full animate-spin w-4 h-4 mr-4`"
        ></div>
        Login
      </button>

      <!-- Google Sign In Button -->
      <div class="mt-4">
          <div ref="googleBtn" class="w-full flex justify-center"></div>
      </div>
      <div class="mt-4 text-xs text-grey-300">
        <a class="text-red-200 no-underline border-b border-red-300" href="#">
          Forgot your password?
        </a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["login", "loggedIn", "loading", "title", "description"],
  mounted() {
    this.initGoogleBtn();
  },
  methods: {
    initGoogleBtn() {
      const clientId = this.$store.state.googleClientId;
      if (window.google && window.google.accounts && clientId) {
        window.google.accounts.id.initialize({
          client_id: clientId,
          callback: this.handleCredentialResponse
        });
        window.google.accounts.id.renderButton(
          this.$refs.googleBtn,
          { theme: "outline", size: "large", type: "standard", width: "100%" }
        );
      } else if (clientId) {
        // Retry if script not loaded yet
        setTimeout(() => this.initGoogleBtn(), 500);
      }
    },
    handleCredentialResponse(response) {
      this.$store.dispatch('LOGIN_GOOGLE', response.credential);
    }
  }
};
</script>
