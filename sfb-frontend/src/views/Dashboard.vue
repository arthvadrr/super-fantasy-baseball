<script setup lang="ts">
import Nav from '../components/Nav.vue';
import Players from "../components/Players.vue";
</script>

<template>
  <div class="dashboard-container flex items-center justify-center flex-col min-h-screen p-6">
    <div class="dashboard items-center text-center form-inner shadow-md rounded-lg bg-white">
      <Nav title="Dashboard"/>
      <div class="status">
        <h2>Record</h2>
        <div class="record flex-col justify-center">
          <div class="wins">
            <span>Wins:&nbsp;</span>
            <span class="font-bold">{{ wins || 0 }}</span>
          </div>
          <div class="losses">
            <span>Losses:&nbsp;</span>
            <span class="font-bold">{{ losses || 0 }}</span>
          </div>
          <div class="total-games-played">
            <span>Total Games Played:&nbsp;</span>
            <span class="font-bold">{{ totalGamesPlayed || 0 }}</span>
          </div>
        </div>
      </div>
      <div>
        <h2>Players</h2>
        <Players/>
      </div>
    </div>
  </div>
</template>

<style scoped>
.dashboard {
  width     : 100%;
  max-width : 990px;
}
</style>