<template>
    <div
        class="flex items-center justify-center p-4 mb-8 font-semibold text-white rounded-md bg-primary"
    >
        <button @click="$emit('back')">
            <icon name="chevron-left" class="mr-2 w-7 h-7" />
        </button>
        <span class="flex items-center justify-center flex-1 text-lg">{{ date }}</span>
        <button @click="$emit('forward')">
            <icon name="chevron-right" class="ml-2 w-7 h-7" />
        </button>
    </div>
</template>

<script>
export default {
    props: ["date"]
};
</script>
