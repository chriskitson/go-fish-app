<template>
  <header
    class="
      flex flex-wrap
      items-center
      justify-center
      w-full
      bg-white
      border-b
      h-30
    "
  >
    <div
      class="
        flex
        items-center
        justify-center
        w-full
        h-10
        border-b border-grey-200
        bg-grey-300
      "
    >
      <div
        class="
          flex flex-wrap
          items-center
          justify-center
          w-full
          mr-4
          md:max-w-5xl md:justify-end
        "
      >
        <a
          href="/signup"
          class="ml-6 text-sm text-white hover:underline"
          v-if="!user.loggedIn && live"
          >Are you a fishery owner? Sign up here</a
        >

        <a
          href="/login"
          class="ml-6 text-sm text-white hover:underline"
          v-if="!user.loggedIn && live"
          >Login | Register</a
        >
        <!-- <span
                    class="ml-3 text-sm text-white"
                    v-if="user.loggedIn && live"
                    >Welcome back</span
                > -->
        <button
          @click="$emit('cache')"
          v-if="user.loggedIn && user.globalAdmin && live"
          class="ml-6 text-sm text-white"
        >
          Clear Cache
        </button>
        <a
          class="ml-6 text-sm text-white"
          v-if="user.loggedIn && user.globalAdmin && live"
          href="/manage-venues"
          >Manage Venues</a
        >
        <a
          class="ml-6 text-sm text-white"
          v-if="user.loggedIn && user.userType === userType.FISHERY && live"
          :href="`/manage-venues/${user.venue.id}`"
          >Manage Venue</a
        >
        <a
          class="ml-6 text-sm text-white"
          v-if="user.loggedIn && user.userType === userType.FISHERY && live"
          :href="`/bookings`"
          >Bookings</a
        >
        <a
          class="ml-6 text-sm text-white"
          v-if="user.loggedIn && live"
          href="/tickets"
          >My Tickets</a
        >
        <button
          @click="$emit('logout')"
          v-if="user.loggedIn && live"
          class="ml-6 text-sm text-white"
        >
          Log out
        </button>
      </div>
    </div>
    <div class="flex flex-wrap items-center w-full max-w-5xl mx-4">
      <div class="flex items-center h-20 w-28">
        <h1>
          <a href="/"><img src="/images/logo.png" alt="GoFish Logo" /></a>
        </h1>
      </div>
      <div class="flex items-center flex-grow hidden ml-5 lg:block">
        <a
          href="/category/latest"
          class="mr-3 font-semibold text-md text-grey-300"
          >Latest Fisheries</a
        >
        <a
          href="/category/near"
          class="mr-3 font-semibold text-md text-grey-300"
          >Fisheries Near Me</a
        >
        <a
          href="/category/best"
          class="mr-3 font-semibold text-md text-grey-300"
          >Best Fisheries</a
        >
        <a href="/login" class="mr-3 font-semibold text-md text-grey-300"
          >Join GoFish</a
        >
        <span class="flex-grow"></span>
      </div>
      <div class="flex items-center justify-end flex-grow">
        <a
          href="/basket"
          class="flex items-center px-5 py-2 text-lg font-semibold text-red-200"
          v-if="user.loggedIn && live"
        >
          <icon name="shopping-cart" class="mr-2 w-7 h-7" v-if="live" />
          {{ basketTotal }}</a
        >
      </div>
    </div>
  </header>
</template>

<script>
import { userType } from "../../../store/state";
export default {
  props: ["user", "live", "basketCount", "basketTotal"],
  data: () => ({
    userType,
  }),
};
</script>
