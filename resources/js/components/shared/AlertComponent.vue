<template>
    <div
        :class="
            `p-2 my-5 rounded-xl${type === 'error' ? ' bg-error' : ''}${
                type === 'success' ? ' bg-success' : ''
            }`
        "
    >
        {{ message }}
    </div>
</template>

<script>
export default {
    props: ["type", "message"]
};
</script>
