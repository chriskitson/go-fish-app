<template>
    <div class="w-full p-4 rounded-md cursor-pointer bg-primary">
        <span class="text-sm text-white h-30 overflow-ellipsis" v-if="live">
            {{ ticket.name }}
        </span>
        <span class="text-sm text-white h-30 overflow-ellipsis" v-if="live">
            &pound;{{ ticket.cost }}
        </span>
    </div>
</template>

<script>
export default {
    props: ["ticket", "live", "display"]
};
</script>
