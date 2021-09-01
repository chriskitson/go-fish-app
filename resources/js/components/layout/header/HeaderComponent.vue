<template>
    <header
        class="flex flex-wrap items-center justify-center w-full bg-white border-b h-30 border-light"
    >
        <div
            class="flex items-center justify-center w-full h-10 border-b border-light"
        >
            <div
                class="flex flex-wrap items-center justify-end w-full max-w-5xl"
            >
                <a
                    href="/login"
                    class="ml-3 text-sm text-primary"
                    v-if="!user.loggedIn && live"
                    >Login | Register</a
                >
                <span class="ml-3 text-sm" v-if="user.loggedIn && live"
                    >Welcome back</span
                >
                <button
                    @click="$emit('logout')"
                    v-if="user.loggedIn && live"
                    class="ml-3 text-sm text-primary"
                >
                    Log out
                </button>
            </div>
        </div>
        <div class="flex flex-wrap items-center w-full max-w-5xl">
            <div class="flex items-center h-20 w-28">
                <h1>
                    <a href="/" class="text-xl font-semibold text-primary"
                        >GoFish!</a
                    >
                </h1>
            </div>
            <div class="flex items-center flex-grow ml-5">
                <a href="#" class="mr-3 text-sm text-primary">Hot Deals</a>
                <a href="#" class="mr-3 text-sm text-primary"
                    >Fisheries Near Me</a
                >
                <a href="#" class="mr-3 text-sm text-primary">Best Fisheries</a>
                <a href="#" class="mr-3 text-sm text-primary">Join GoFish</a>
                <span class="flex-grow"></span>
                <a
                    href="/basket"
                    class="px-5 py-2 text-lg font-semibold text-white rounded-full bg-primary"
                    v-if="user.loggedIn && live"
                    >Basket - {{ basketCount }}</a
                >
            </div>
        </div>
    </header>
</template>

<script>
export default {
    props: ["user", "live", "basketCount"]
};
</script>
