<template>
  <div class="mb-8">
    <h3 class="my-8 text-xl font-semibold text-red-200">Details</h3>
    <div class="md:grid md:grid-cols-2 md:gap-6">
      <div class="mb-8 md:mb-0">
        <label class="block mb-2 font-semibold text-grey-300">Name</label>
        <input
          type="text"
          :class="`w-full p-2 mb-5 text-sm border rounded-md b-grey-200 disabled:background-grey-200${errorStyle(
            'name'
          )}`"
          :disabled="loading"
          v-model="venue.name"
        />
      </div>
      <div class="mb-8 md:mb-0">
        <label class="block mb-2 font-semibold text-grey-300">Image</label>
        <input
          type="file"
          accept="image/*"
          @change="$emit('uploadImage', $event)"
          :class="`w-full p-2 mb-5 text-sm border rounded-md b-grey-200 disabled:background-grey-200${errorStyle(
            'image'
          )}`"
          :disabled="loading"
        />
        <img
          v-if="venue.image"
          :src="venue.image"
          :alt="`${venue.name} image`"
          class="w-full"
        />
        <button
          @click="$emit('deleteImage')"
          v-if="venue.image"
          class="
            flex
            items-center
            justify-center
            px-3
            py-2
            mt-4
            ml-2
            text-sm text-white
            rounded-lg
            bg-orange-200
            disabled:opacity-50
          "
          :disabled="loading"
        >
          <icon name="trash" class="w-4 h-4 mr-2" />
          Delete image
        </button>
      </div>
      <div class="mb-8 md:mb-0">
        <label class="block mb-2 font-semibold text-grey-300"
          >Description</label
        >


        <textarea
          v-model="venue.description"
          :class="`w-full h-56 p-4 text-sm border rounded-md b-grey-200 disabled:background-grey-200${errorStyle(
            'description'
          )}`"
          :disabled="loading"
        ></textarea>
      </div>
      <div class="mb-8 md:mb-0">
        <label class="block mb-2 font-semibold text-grey-300">Rules</label>
        <textarea
          v-model="venue.rules"
          :class="`w-full h-56 p-4 text-sm border rounded-md b-grey-200 disabled:background-grey-200${errorStyle(
            'rules'
          )}`"
          :disabled="loading"
        ></textarea>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  props: ["loading", "venue", "manageVenueErrorFields"],
  methods: {
    errorStyle(key) {
      return this.manageVenueErrorFields?.indexOf(key) > -1
        ? " border-red-200"
        : "";
    },
  },
};
</script>
