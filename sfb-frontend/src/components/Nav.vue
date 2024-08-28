<!--suppress ALL -->
<script setup lang="ts">
defineProps<{
  title?: string;
}>();
</script>

<template>
  <nav>
    <div class="mx-auto flex-col justify-between items-center bg-sfb-bg-orange pb-6 border-b-2  border-b-gray-300 rounded-tr-2xl rounded-tl-2xl">
      <div class="flex items-center justify-between w-full p-2 pr-4 pl-4">
        <img src="/images/sfb-logo-400x400.webp" alt="Logo" class="w-12 h-12"/>
        <h1 class="text-xl">Super Fantasy Baseball — {{ title }}</h1>
        <img src="" alt="Profile" class="w-12 h-12 rounded-full border-2"/>
      </div>
      <ul class="flex justify-center space-x-2">
        <li>
          <router-link to="/dashboard"
                       class="text-white rounded-full p-2 pl-4 pr-4 bg-gradient-to-b from-sfb-dark-blue to-gray-700">
            Dashboard
          </router-link>
        </li>
        <li>
          <router-link to="/roster"
                       class="bg-sfb-dark-blue text-white rounded-full p-2 pl-4 pr-4 bg-gradient-to-b from-sfb-dark-blue to-gray-700">
            Roster
          </router-link>
        </li>
        <li>
          <router-link to="/league"
                       class="bg-sfb-dark-blue text-white rounded-full p-2 pl-4 pr-4 bg-gradient-to-b from-sfb-dark-blue to-gray-700">
            League
          </router-link>
        </li>
        <li>
          <router-link to="/calendar"
                       class="bg-sfb-dark-blue text-white rounded-full p-2 pl-4 pr-4 bg-gradient-to-b from-sfb-dark-blue to-gray-700">
            Calendar
          </router-link>
        </li>
      </ul>
    </div>
  </nav>
</template>