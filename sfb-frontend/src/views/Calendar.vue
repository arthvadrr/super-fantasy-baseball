<script setup lang="ts">
import Nav from '../components/Nav.vue';
</script>

<template>
  <div class="calendar-container flex items-center justify-center flex-col min-h-screen p-6">
    <div class="calendar items-center text-center form-inner shadow-md bg-white rounded-lg">
      <Nav title="calendar"/>
    </div>
  </div>
</template>

<style scoped>
.calendar {
  width     : 100%;
  max-width : 990px;
}
</style>