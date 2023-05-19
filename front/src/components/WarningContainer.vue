<template>
    <div class="alert alert-warning mt-4" role="alert">
        {{ warning }}
    </div>
</template>

<script setup>
const props = defineProps(['warning'])

</script>

<style lang="scss" scoped>

</style>