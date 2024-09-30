<script setup lang="ts">
import Nav from '../components/Nav.vue';
</script>

<template>
  <div class="league-container flex items-center justify-center flex-col min-h-screen p-6">
    <div class="league items-center text-center form-inner shadow-md bg-white rounded-lg">
      <Nav title="league"/>
    </div>
  </div>
</template>

<style scoped>
.league {
  width     : 100%;
  max-width : 990px;
}
</style>