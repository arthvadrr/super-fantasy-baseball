<script setup lang="ts">

</script>

<template>
  <main>
    <RouterView/>
  </main>
</template>

<style>
  main {
    background-image: url("/images/phil-goodwin-unsplash-bg.webp");
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;
    position: relative;
    z-index: 0;

    &::after {
      content: "";
      height: 100%;
      width: 100%;
      display: block;
      background-image: linear-gradient(to right bottom,
      rgba(255, 133, 0, 0.65), /* #ff8400 */
        rgba(0, 0, 0, 0.9)      /* #000000 */
      );

      backdrop-filter: blur(10px);
      position:absolute;
      top: 0;
      left: 0;
      z-index: -1;
    }
  }
</style>