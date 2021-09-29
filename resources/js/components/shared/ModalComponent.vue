<template>
    <div
        class="fixed inset-0 z-10 overflow-y-auto"
        aria-labelledby="modal-title"
        role="dialog"
        aria-modal="true"
    >
        <div
            class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0"
        >
            <div
                class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"
                aria-hidden="true"
            ></div>
            <span
                class="hidden sm:inline-block sm:align-middle sm:h-screen"
                aria-hidden="true"
                >&#8203;</span
            >
            <div
                class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
            >
                <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                    <button
                        class="absolute top-4 right-4"
                        @click="$emit('close', message)"
                    >
                        <icon name="x" class="w-6 h-6" />
                    </button>

                    <div class="mt-8 mb-8 sm:flex sm:items-start">
                        <div
                            :class="
                                `flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto rounded-full sm:mx-0 sm:h-10 sm:w-10${
                                    type === 'error' ? ' bg-error' : ''
                                }${type === 'success' ? ' bg-success' : ''}${
                                    !type || type === '' ? ' bg-grey-200' : ''
                                }`
                            "
                        >
                            <icon
                                name="shield-exclamation"
                                class="w-6 h-6"
                                v-if="type === 'error'"
                            />
                            <icon
                                name="shield-check"
                                class="w-6 h-6"
                                v-if="type === 'success'"
                            />
                        </div>
                        <div
                            class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left"
                        >
                            <p class="text-lg font-medium text-gray-900">
                                {{ MESSAGES.ERRORS[message] }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { MESSAGES } from "../../config/messages";
export default {
    props: ["message", "type"],
    data: () => ({
        MESSAGES
    })
};
</script>
