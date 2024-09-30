<script setup lang="ts">
import Nav from '../components/Nav.vue';
</script>

<template>
  <div class="roster-container flex items-center justify-center flex-col min-h-screen p-6">
    <div class="roster items-center text-center form-inner shadow-md bg-white rounded-lg">
      <Nav title="roster"/>
    </div>
  </div>
</template>

<style scoped>
.roster {
  width     : 100%;
  max-width : 990px;
}
</style>