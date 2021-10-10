<template>
    <div :class="`w-full mb-4 md:w-1/${display} h-40 flex items-end bg-cover p-3 ${live ? '' : 'bg-opacity-50 '}bg-grey-100 rounded-xl`" :style="`background-image:url('${category ? category.img : ''}')`">
        <a href="#" v-if="live" class="text-xl font-bold text-white">
            {{ category.name }}
        </a>
    </div>
</template>

<script>
export default {
    props: ["category", "live", "display"]
};
</script>
