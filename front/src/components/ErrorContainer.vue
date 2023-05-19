<template>
    <div class="alert alert-danger mt-4" role="alert">
        {{ error }}
    </div>
</template>

<script setup>
const props = defineProps(['error'])

</script>

<style lang="scss" scoped>

</style>