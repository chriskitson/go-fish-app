<template>
    <div class="w-full max-w-5xl mb-10">
        <h2 class="flex items-center mb-4 text-xl font-semibold">
            {{ live ? title : "Tickets loading..." }}
        </h2>
        <div
            class="flex flex-wrap items-center w-full space-y-4 py-50"
            v-if="live && items.length > 0"
        >
            <basket-item-component
                v-for="item in items"
                :key="`live-${item.id}`"
                :live="live"
                :item="item"
                :display="display"
                :auth="auth"
                :loggedIn="loggedIn"
                @book="$emit('book', $event)"
            ></basket-item-component>
        </div>
        <div v-if="live && items.length === 0">
            There are no tickets availble for this venue on this date.
        </div>
        <div
            class="flex flex-wrap items-center w-full space-y-4 py-50"
            v-if="!live"
        >
            <basket-item-component
                :live="live"
                :display="display"
            ></basket-item-component>
            <basket-item-component
                :live="live"
                :display="display"
            ></basket-item-component>
            <basket-item-component
                :live="live"
                :display="display"
            ></basket-item-component>
            <basket-item-component
                :live="live"
                :display="display"
            ></basket-item-component>
        </div>
    </div>
</template>

<script>
export default {
    props: ["title", "items", "live", "display", "auth", "loggedIn"]
};
</script>
