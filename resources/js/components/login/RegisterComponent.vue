<template>
    <div class="container flex flex-col items-center flex-1 px-2 mx-auto">
        <div
            class="w-full px-6 py-8 text-black bg-white rounded shadow-md bg-opacity-80"
        >
            <h1 class="mb-8 text-xl text-center text-red-200">
                New users register to GoFish!
            </h1>
            <alert-component
                v-if="register.errors.length > 0"
                :message="register.errors.join(', ')"
                type="error"
            ></alert-component>
            <alert-component
                v-if="register.messages.length > 0"
                :message="register.messages.join(', ')"
                type="success"
            ></alert-component>
            <input
                type="text"
                class="block w-full p-3 mb-4 text-sm border rounded border-grey-100"
                name="fullname"
                placeholder="Full Name"
                v-model="register.name"
            />
            <input
                type="text"
                class="block w-full p-3 mb-4 text-sm border rounded border-grey-100"
                name="email"
                placeholder="Email"
                v-model="register.email"
            />
            <input
                type="password"
                class="block w-full p-3 mb-4 text-sm border rounded border-grey-100"
                name="password"
                placeholder="Password"
                v-model="register.password"
            />
            <input
                type="password"
                class="block w-full p-3 mb-4 text-sm border rounded border-grey-100"
                name="confirm_password"
                placeholder="Confirm Password"
                v-model="register.confirm"
            />
            <button
                type="submit"
                :disabled="loading || loggedIn"
                class="flex w-full p-3 my-1 text-sm text-center text-white bg-red-200 rounded focus:outline-none align-center justify-items-center disabled:opacity-50"
                @click="$emit('register')"
            >
                <div
                    v-if="loading"
                    :class="
                        `border-t-4 border-b-3 rounded-full animate-spin w-4 h-4 mr-4`
                    "
                ></div>
                Create Account
            </button>
            <div class="mt-4 text-xs text-center text-grey-300">
                By signing up, you agree to the
                <a
                    class="no-underline border-b border-grey-300 text-grey-300"
                    href="#"
                >
                    Terms of Service
                </a>
                and
                <a
                    class="no-underline border-b border-grey-300 text-grey-300"
                    href="#"
                >
                    Privacy Policy
                </a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["register", "loggedIn", "loading"]
};
</script>
