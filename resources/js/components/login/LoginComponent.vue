<template>
    <div class="container flex flex-col items-center flex-1 px-2 mx-auto">
        <div
            class="w-full px-6 py-8 text-black bg-white rounded shadow-md"
            v-if="!loggedIn"
        >
            <h1 class="mb-8 text-3xl text-center text-primary">
                Login to GoFish!
            </h1>
            <alert-component
                v-if="login.errors.length > 0"
                :message="login.errors.join(', ')"
                type="error"
            ></alert-component>
            <alert-component
                v-if="login.messages.length > 0"
                :message="login.messages.join(', ')"
                type="success"
            ></alert-component>
            <input
                type="text"
                class="block w-full p-3 mb-4 border rounded border-grey-light"
                name="email"
                placeholder="Email"
                v-model="login.email"
            />
            <input
                type="password"
                class="block w-full p-3 mb-4 border rounded border-grey-light"
                name="password"
                placeholder="Password"
                v-model="login.password"
            />
            <button
                type="submit"
                class="w-full py-3 my-1 text-center text-white rounded bg-primary hover:bg-secondary focus:outline-none"
                @click="$emit('login')"
            >
                Login
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props: ["login", "loggedIn"]
};
</script>
