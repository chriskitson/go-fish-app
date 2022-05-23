<template>
  <a
    :href="live ? `/venue/${venue.id}` : '#'"
    :class="`mb-4 flex items-end w-full h-48 p-3 ${
      live ? '' : 'bg-opacity-50 '
    }bg-grey-300 bg-opacity-70 rounded-xl bg-cover`"
    :style="`background-image:url('${live ? venueImage : ''}')`"
  >
    <div v-if="live" class="flex flex-col flex-wrap">
      <rating-component
        :max="5"
        :current="parseFloat(venue.rating) || 0"
      ></rating-component>
      <span class="text-xl font-bold text-white"
        >{{ venue.name }}
        {{ venue.distanceDisplay ? ` - ${venue.distanceDisplay}` : "" }}</span
      >
    </div>
    <div class="flex items-center justify-center w-full h-full" v-if="!live">
      <spinner-component />
    </div>
  </a>
</template>

<script>
export default {
  props: ["venue", "live"],
  computed: {
    venueImage: function () {
      let image = this.venue.image;
      if (image === "" && this.venue.photos.length > 0) {
        image = this.venue.photos[0];
      }
      return image;
    },
  },
};
</script>
