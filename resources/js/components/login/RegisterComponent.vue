<template>
    <div class="container flex flex-col items-center flex-1 px-2 mx-auto">
        <div
            class="w-full px-6 py-8 text-black bg-white rounded shadow-md"
            v-if="!loggedIn"
        >
            <h1 class="mb-8 text-3xl text-center text-primary">New users</h1>
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
                class="block w-full p-3 mb-4 border rounded border-grey-light"
                name="fullname"
                placeholder="Full Name"
                v-model="register.name"
            />
            <input
                type="text"
                class="block w-full p-3 mb-4 border rounded border-grey-light"
                name="email"
                placeholder="Email"
                v-model="register.email"
            />
            <input
                type="password"
                class="block w-full p-3 mb-4 border rounded border-grey-light"
                name="password"
                placeholder="Password"
                v-model="register.password"
            />
            <input
                type="password"
                class="block w-full p-3 mb-4 border rounded border-grey-light"
                name="confirm_password"
                placeholder="Confirm Password"
                v-model="register.confirm"
            />
            <button
                type="submit"
                class="w-full py-3 my-1 text-center text-white rounded bg-primary hover:bg-secondary focus:outline-none"
                @click="$emit('register')"
            >
                Create Account
            </button>
            <div class="mt-4 text-sm text-center text-grey-dark">
                By signing up, you agree to the
                <a
                    class="no-underline border-b border-grey-dark text-grey-dark"
                    href="#"
                >
                    Terms of Service
                </a>
                and
                <a
                    class="no-underline border-b border-grey-dark text-grey-dark"
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
    props: ["register", "loggedIn"]
};
</script>
