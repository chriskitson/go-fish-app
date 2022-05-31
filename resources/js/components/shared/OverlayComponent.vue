<template>
  <div
    class="fixed inset-0 z-10 overflow-y-auto w-full"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true"
  >
    <div
      class="
        flex
        items-end
        justify-center
        min-h-screen
        px-4
        pt-4
        pb-20
        text-center
        sm:block sm:p-0
        w-full
      "
    >
      <div
        class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"
        aria-hidden="true"
      ></div>
      <span
        class="hidden sm:inline-block sm:align-middle sm:h-screen"
        aria-hidden="true"
        >&#8203;</span
      >
      <div
        class="
          inline-block
          overflow-hidden
          text-left
          align-bottom
          transition-all
          transform
          bg-white
          rounded-lg
          shadow-xl
          w-full
          h-full
        "
      >
        <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
          <button
            class="absolute top-4 right-4"
            @click="$emit('close', message)"
          >
            <icon name="x" class="w-6 h-6" />
          </button>
          <div v-html="html" class="pt-8"></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["html"]
};
</script>
