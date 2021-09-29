<template>
    <header
        class="flex flex-wrap items-center justify-center w-full bg-white border-b h-30"
    >
        <div
            class="flex items-center justify-center w-full h-10 border-b border-light bg-grey-300"
        >
            <div
                class="flex flex-wrap items-center justify-end w-full max-w-5xl mr-4"
            >
                <a
                    href="/login"
                    class="ml-3 text-sm text-white"
                    v-if="!user.loggedIn && live"
                    >Login | Register</a
                >
                <span
                    class="ml-3 text-sm text-white"
                    v-if="user.loggedIn && live"
                    >Welcome back</span
                >
                <button
                    @click="$emit('logout')"
                    v-if="user.loggedIn && live"
                    class="ml-3 text-sm text-white"
                >
                    Log out
                </button>
            </div>
        </div>
        <div class="flex flex-wrap items-center w-full max-w-5xl mx-4">
            <div class="flex items-center h-20 w-28">
                <h1>
                    <a href="/"><img src="/images/logo.png" alt="GoFish Logo" /></a>
                </h1>
            </div>
            <div class="flex items-center flex-grow ml-5">
                <a href="#" class="mr-3 font-semibold text-md text-grey-300"
                    >Hot Deals</a
                >
                <a href="#" class="mr-3 font-semibold text-md text-grey-300"
                    >Fisheries Near Me</a
                >
                <a href="#" class="mr-3 font-semibold text-md text-grey-300"
                    >Best Fisheries</a
                >
                <a href="#" class="mr-3 font-semibold text-md text-grey-300"
                    >Join GoFish</a
                >
                <span class="flex-grow"></span>
                <a
                    href="/basket"
                    class="flex items-center px-5 py-2 text-lg font-semibold text-red-200"
                    v-if="user.loggedIn && live"
                >
                    <icon
                        name="shopping-cart"
                        class="mr-2 w-7 h-7"
                        v-if="live"
                    />
                    {{ basketTotal }}</a
                >
            </div>
        </div>
    </header>
</template>

<script>
export default {
    props: ["user", "live", "basketCount", "basketTotal"]
};
</script>
