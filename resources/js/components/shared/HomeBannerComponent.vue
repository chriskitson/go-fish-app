<template>
  <div
    class="
      my-5
      bg-cover
      h-72
      rounded-xl
      flex
      items-center
      justify-center
      bg-grey-300
      bg-opacity-50
    "
    :style="`background-image: url('${imageURL}');`"
  >
    <span
      v-if="message && message !== ''"
      class="text-2xl text-white font-semibold text-center p-4"
      >{{ message }}</span
    >
    &nbsp;
  </div>
</template>

<script>
export default {
  props: ["imageURL", "message"],
};
</script>