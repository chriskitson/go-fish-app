<template>
  <ul class="flex border-b list-reset">
    <li class="mr-1 -mb-px">
      <a
        :class="`inline-block px-4 py-2 font-semibold bg-white text-blue-dark${
          active === manageTabs.DETAILS
            ? ' rounded-t border-t border-l border-r'
            : ''
        }`"
        href="#"
        @click.prevent="$emit('setTab', manageTabs.DETAILS)"
        >Details</a
      >
    </li>
    <li class="mr-1 -mb-px">
      <a
        :class="`inline-block px-4 py-2 font-semibold bg-white text-blue-dark${
          active === manageTabs.HOURS
            ? ' rounded-t border-t border-l border-r'
            : ''
        }`"
        href="#"
        @click.prevent="$emit('setTab', manageTabs.HOURS)"
        >Opening Days</a
      >
    </li>
    <li class="mr-1 -mb-px" v-if="isGlobalAdmin">
      <a
        :class="`inline-block px-4 py-2 font-semibold bg-white text-blue-dark${
          active === manageTabs.PAYMENT
            ? ' rounded-t border-t border-l border-r'
            : ''
        }`"
        href="#"
        @click.prevent="$emit('setTab', manageTabs.PAYMENT)"
        >Payment</a
      >
    </li>
    <li class="mr-1 -mb-px">
      <a
        :class="`inline-block px-4 py-2 font-semibold bg-white text-blue-dark${
          active === manageTabs.LOCATION
            ? ' rounded-t border-t border-l border-r'
            : ''
        }`"
        href="#"
        @click.prevent="$emit('setTab', manageTabs.LOCATION)"
        >Location</a
      >
    </li>
    <li class="mr-1 -mb-px">
      <a
        :class="`inline-block px-4 py-2 font-semibold bg-white text-blue-dark${
          active === manageTabs.TICKETS
            ? ' rounded-t border-t border-l border-r'
            : ''
        }`"
        href="#"
        @click.prevent="$emit('setTab', manageTabs.TICKETS)"
        >Tickets</a
      >
    </li>
  </ul>
</template>

<script>
import { manageTabs } from "../../store/state";
export default {
  props: ["isGlobalAdmin", "active"],
  data: () => ({
    manageTabs,
  }),
};
</script>
