<template>
<div class="text-center" v-if="loading">
    <b-spinner variant="info" label="Text Centered" style="width: 5rem; height: 5rem;" class="mt-5 mb-5"></b-spinner>
</div>
</template>

<script>
    export default {
        props:{
            loading: Boolean
        }
    }
</script>