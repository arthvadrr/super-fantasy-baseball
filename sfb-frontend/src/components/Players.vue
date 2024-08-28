<template>
  <div v-if="error" class="error">
    <p>{{ error }}</p>
  </div>
  <div v-else class="max-h-96 overflow-scroll">
    <table v-if="players.length" class="table-auto w-full border-2">
      <thead>
      <tr>
        <th class="border px-4 py-2">Name</th>
        <th class="border px-4 py-2">Position</th>
        <th class="border px-4 py-2">Batting Average</th>
        <th class="border px-4 py-2">Home Runs</th>
        <th class="border px-4 py-2">RBIs</th>
        <th class="border px-4 py-2">Stolen Bases</th>
        <th class="border px-4 py-2">ERA</th>
        <th class="border px-4 py-2">Strikeouts</th>
        <th class="border px-4 py-2">Walks</th>
        <th class="border px-4 py-2">Fielding Percentage</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="player in players" :key="player.id">
        <td class="border px-4 py-2">{{ player.name }}</td>
        <td class="border px-4 py-2">{{ player.meta.position }}</td>
        <td class="border px-4 py-2">{{ player.meta.batting_average }}</td>
        <td class="border px-4 py-2">{{ player.meta.home_runs }}</td>
        <td class="border px-4 py-2">{{ player.meta.RBIs }}</td>
        <td class="border px-4 py-2">{{ player.meta.stolen_bases }}</td>
        <td class="border px-4 py-2">{{ player.meta.ERA }}</td>
        <td class="border px-4 py-2">{{ player.meta.strikeouts }}</td>
        <td class="border px-4 py-2">{{ player.meta.walks }}</td>
        <td class="border px-4 py-2">{{ player.meta.fielding_percentage }}</td>
      </tr>
      </tbody>
    </table>
    <p v-else>No players found.</p>
  </div>
</template>

<script lang="ts">
import {ref, onMounted} from 'vue';

export default {
  name: 'PlayersList',
  setup() {
    const players = ref<any[]>([]);
    const error = ref<string | null>(null);

    const validateToken = async (token: string) => {
      try {
        const response = await fetch('http://super-fantasy-baseball.local/wp-json/jwt-auth/v1/token/validate', {
          method: 'POST',
          header: {
            'Authorization': `Bearer ${token}`
          }
        });

        if (!response.ok) {
          new Error('Token is invalid');
        }

        return true;
      } catch (err) {
        error.value = 'Token validation failed or network error';
        return false;
      }
    };

    // Function to fetch players data
    const fetchPlayers = async () => {
      const token = localStorage.getItem('sfb-auth-jwt');

      if (token) {
        const isValid = await validateToken(token);

        if (isValid) {
          try {
            const wphost = import.meta.env.VITE_LOCAL_HOST;
            const playerEndpoint = import.meta.env.VITE_WP_PLAYER_ENDPOINT;
            const playerRequest = `${wphost}/${playerEndpoint}`;
            const response = await fetch(playerRequest);

            if (!response.ok) {
              console.log('RES IS NOT OK');
              new Error('Failed to fetch players');
            }

            const data = await response.json();

            players.value = data.map((player: any) => ({
              id: player.id,
              name: player.title.rendered,
              meta: {
                position: player.meta.position[0] || 'N/A',
                batting_average: player.meta.batting_average[0] || 'N/A',
                home_runs: player.meta.home_runs[0] || 'N/A',
                RBIs: player.meta.RBIs[0] || 'N/A',
                stolen_bases: player.meta.stolen_bases[0] || 'N/A',
                ERA: player.meta.ERA[0] || 'N/A',
                strikeouts: player.meta.strikeouts[0] || 'N/A',
                walks: player.meta.walks[0] || 'N/A',
                fielding_percentage: player.meta.fielding_percentage[0] || 'N/A'
              }
            }));
          } catch (err) {
            error.value = 'Failed to fetch players data';
          }
        }
      } else {
        error.value = 'No token found';
      }
    };

    onMounted(fetchPlayers);

    return {players, error};
  }
};
</script>

<style scoped>
.error {
  color       : red;
  font-weight : bold;
}

.table-auto {
  width           : 100%;
  border-collapse : collapse;
}
</style>