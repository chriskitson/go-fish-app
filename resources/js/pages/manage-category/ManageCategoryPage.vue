<template>
  <div class="w-full max-w-5xl px-4 mx-auto">
    <div class="mt-10 mb-20">
      <div class="mb-4">
        <h2 class="text-xl font-semibold text-red-200">
          {{ category.name }}
        </h2>
        <div class="flex justify-start w-full mt-4">
          <a
            href="/manage-categories"
            class="
              flex
              items-center
              justify-center
              px-3
              py-2
              text-sm text-white
              bg-grey-200
              rounded-lg
            "
          >
            <icon name="chevron-left" class="w-4 h-4 mr-2" />
            Back to Categories
          </a>
        </div>
      </div>

      <div class="mb-8 p-6 bg-white rounded-xl shadow-sm border border-grey-200">
        <h3 class="my-4 text-xl font-semibold text-red-200">Details</h3>
        <div class="md:grid md:grid-cols-2 md:gap-6">
          <div class="mb-8 md:mb-0">
            <label class="block mb-2 font-semibold text-grey-300">Name</label>
            <p class="p-2 text-sm border rounded-md b-grey-200 bg-grey-100">{{ category.name }}</p>
          </div>
          
          <div class="mb-8 md:mb-0">
            <label class="block mb-2 font-semibold text-grey-300">Type</label>
            <p class="p-2 text-sm border rounded-md b-grey-200 bg-grey-100">
              {{ category.key === 'administrative_area_level_1' ? 'Region / Country' : 'County' }}
            </p>
          </div>

          <div class="mb-8 md:mb-0">
            <label class="block mb-2 font-semibold text-grey-300">Key</label>
            <p class="p-2 text-sm border rounded-md b-grey-200 bg-grey-100">{{ category.key }}</p>
          </div>

          <div class="mb-8 md:mb-0">
            <label class="block mb-2 font-semibold text-grey-300">Value</label>
            <p class="p-2 text-sm border rounded-md b-grey-200 bg-grey-100">{{ category.value }}</p>
          </div>

          <div class="mb-8 md:mb-0">
            <label class="block mb-2 font-semibold text-grey-300">Image</label>
            <input
              type="file"
              accept="image/*"
              @change="uploadImage"
              :class="`w-full p-2 mb-5 text-sm border rounded-md b-grey-200 disabled:background-grey-200`"
              :disabled="loading"
            />
            <img
              v-if="category.image"
              :src="category.image"
              :alt="`${category.name} image`"
              class="w-full rounded-lg shadow-sm"
            />
            <button
              @click="deleteImage"
              v-if="category.image"
              class="
                flex
                items-center
                justify-center
                px-3
                py-2
                mt-4
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
        </div>
      </div>
    </div>
    <page-spinner-component v-if="loading" />
  </div>
</template>

<script>
import { mapState } from "vuex";

export default {
  computed: {
    ...mapState({
      category: (state) => state.manageCategory,
      user: (state) => state.user,
      loading: (state) => state.loading
    }),
  },
  methods: {
    uploadImage(event) {
      if (event.target.files && event.target.files.length > 0) {
        const image = event.target.files[0];
        this.$store.dispatch("CATEGORY_MANAGE_IMAGE_UPDATE", {
          id: this.$route.params.id,
          image,
          user: this.user
        });
      }
    },
    deleteImage() {
      if (confirm("Are you sure you want to remove this category image?")) {
        this.$store.dispatch("CATEGORY_MANAGE_IMAGE_DELETE", {
          id: this.$route.params.id,
          user: this.user
        });
      }
    }
  },
  mounted() {
    this.$store.dispatch("CATEGORY_MANAGE_GET", {
      id: this.$route.params.id,
      user: this.user
    });
  },
};
</script>
