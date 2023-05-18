<template>
    <table class="table table-dark">
  <thead>
    <tr>
        <td v-for="(item, index) in columns">
      {{ item }}
        </td>
    </tr>
  </thead>
  <tbody>
    <tr v-for="(row, index) in rows" :key="index">
        <td v-for="(value, columnIndex) in row" :key="columnIndex">
          {{ value }}
        </td>
      </tr>
  </tbody>
</table>
</template>

<script setup>
const props = defineProps(['columns', 'rows'])

</script>

<style lang="scss" scoped>

</style>