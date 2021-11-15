<template>
    <div :class="`w-full mb-4 h-40 flex items-end bg-cover p-3 ${live ? '' : 'bg-opacity-50 '}bg-grey-200 rounded-xl`" :style="`background-image:url('${category ? category.image : ''}')`">
        <a :href="`/category/${category.id}`" v-if="live" class="text-xl font-bold text-white">
            {{ category.name }}
        </a>
    </div>
</template>

<script>
export default {
    props: ["category", "live", "display"]
};
</script>
