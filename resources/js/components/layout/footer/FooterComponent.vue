<template>
  <footer
    class="
      flex
      items-center
      justify-center
      w-full
      px-8
      pt-16
      pb-8
      mt-10
      bg-grey-300
    "
  >
    <div class="grid w-full grid-cols-1 gap-4 md:grid-cols-3">
      <div>
        <h4 class="mb-4 font-semibold text-white">Find fishing venues in:</h4>
        <ul>
          <li v-for="(cat, i) in categories" :key="`footer-cat-${i}`">
            <a
              :href="`/category/${cat.id}`"
              class="text-sm text-white hover:underline"
              >{{ cat.name }}</a
            >
          </li>
        </ul>
      </div>
      <div>
        <h4 class="mb-4 font-semibold text-white">Useful Links:</h4>
        <ul>
          <li v-for="(link, i) in usefulLinks" :key="`footer-link-${i}`">
            <a :href="link.url" class="text-sm text-white hover:underline">{{
              link.name
            }}</a>
          </li>
        </ul>
      </div>
      <div>
        <h4 class="mb-4 font-semibold text-white">Information:</h4>
        <ul>
          <li v-for="(link, i) in informationLinks" :key="`footer-link-${i}`">
            <a :href="link.url" class="text-sm text-white hover:underline">{{
              link.name
            }}</a>
          </li>
        </ul>
      </div>
      <div class="mt-8 text-xs text-center text-white col-span-full">
        &copy; Copyright {{ new Date().getFullYear() }} GoFish. All rights
        reserved.
      </div>
    </div>
  </footer>
</template>

<script>
export default {
  props: ["categories", "usefulLinks", "informationLinks"],
};
</script>
