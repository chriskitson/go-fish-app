<template>
    <div class="my-5 bg-cover h-72 rounded-xl bg-grey-100" :style="`background-image: url('${imageURL}');`">
        &nbsp;
    </div>
</template>

<script>
export default {
    props: [ "imageURL"]
};
</script>