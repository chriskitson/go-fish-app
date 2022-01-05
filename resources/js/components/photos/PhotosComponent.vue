<template>
  <div class="pt-8 mb-8 border-t border-grey-100">
    <h3 class="mb-4 text-lg font-semibold">Photos of {{ name }}:</h3>
    <client-only>
      <vue-masonry-wall :items="photos" :options="{ width: 300, padding: 12 }">
        <template v-slot:default="{ item }">
          <div class="item">
            <img :src="item.image" />
          </div>
        </template>
      </vue-masonry-wall>
    </client-only>
  </div>
</template>

<script>
import ClientOnly from "vue-client-only";
import VueMasonryWall from "vue-masonry-wall";
export default {
  props: ["name", "photos"],
  components: {
    ClientOnly,
    VueMasonryWall,
  },
};
</script>
