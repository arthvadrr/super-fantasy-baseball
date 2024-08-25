<script>
export default {
  data() {
    return {
      username: '',
      password: '',
    };
  },
  methods: {
    async login() {
      try {
        const HOST = import.meta.env.VITE_LOCAL_HOST;
        const AUTH_ENDPOINT = import.meta.env.VITE_WP_AUTH_ENDPOINT;
        const REQUEST_URI = `${ HOST }/${ AUTH_ENDPOINT }`;

        const response = await fetch(REQUEST_URI, {
          method: 'POST',
          headers: {'Content-Type': 'application/json'},
          body: JSON.stringify({
            username: this.username,
            password: this.password,
          }),
        });

        if (response.ok) {
          const data = await response.json();
          const {token} = data;

          if (token) {
            localStorage.setItem('jwt', token);
            await this.$router.push('/home');
          } else {
            new Error('Token not found in response');
          }
        } else {
          alert('Login failed. Please check your credentials.');
        }
      } catch (error) {
        console.error('Login error:', error);
      }
    },
  },
};
</script>

<template>
  <div class="login">
    <form @submit.prevent="login">
      <input
          v-model="username"
          placeholder="Username"
          required
      />
      <input
          v-model="password"
          type="password"
          placeholder="Password"
          required
      />
      <button type="submit">Login</button>
    </form>
  </div>
</template>