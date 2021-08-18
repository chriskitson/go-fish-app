<template>
    <div :class="`w-full p-4 rounded-md cursor-pointer bg-primary${live ? '' : ' bg-opacity-20'} flex items-center justify-items`">
        <icon name="ticket" class="mr-2 text-white w-7 h-7" v-if="live" />
        <span class="text-sm text-white h-30">
            {{ live ? ticket.name : '&nbsp;' }}
        </span>
        <span class="text-sm text-white h-30">
            {{ live ? `&pound;${ticket.cost}`: '&nbsp;' }}
        </span>
         <span class="text-sm text-white h-30">
            {{ live ? ticket.description : '&nbsp;' }}
        </span>
    </div>
</template>

<script>
export default {
    props: ["ticket", "live", "display"]
};
</script>
