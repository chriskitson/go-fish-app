<template>
  <div class="w-full max-w-5xl px-4 mx-auto">
    <div class="grid grid-cols-3 gap-6 mt-10 mb-20">
      <div class="col-span-3">
        <div class="flex justify-between items-center w-full mb-4">
          <h1 class="text-xl font-semibold text-red-200">Manage Categories</h1>
        </div>
        <ul>
          <li
            v-for="(category, index) in categories"
            :key="category.id"
            :class="`flex items-center justify-center p-2 mb-2${
              index % 2 ? ' bg-white' : ' bg-grey-100'
            }`"
          >
            <a
              :href="`/manage-categories/${category.id}`"
              class="flex-1 text-red-200 hover:underline"
              >{{ category.name }}</a
            >
            <span 
              v-if="category.key === 'administrative_area_level_1'"
              class="ml-2 px-2 py-1 text-xs font-bold text-white bg-blue-500 rounded-lg uppercase"
            >
              Region / Country
            </span>
            <span 
              v-else
              class="ml-2 px-2 py-1 text-xs font-bold text-white bg-red-200 rounded-lg uppercase"
            >
              County
            </span>
            <span
              :class="`ml-2 flex items-center justify-center px-3 py-2 text-sm text-white rounded-lg disabled:opacity-50 ${
                category.image ? 'bg-success' : 'bg-grey-200'
              }`"
            >
              <icon name="photograph" class="w-4 h-4" />
            </span>
          </li>
        </ul>
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
      categories: (state) => state.manageCategories,
      user: (state) => state.user,
      loading: (state) => state.loading
    }),
  },
  mounted() {
    this.$store.dispatch("CATEGORIES_ADMIN_GET", {
      user: this.user,
    });
  },
};
</script>
