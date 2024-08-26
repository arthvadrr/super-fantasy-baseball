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
            localStorage.setItem('sfb-auth-jwt', token);
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
  <div class="login flex items-center min-h-screen justify-center bg-gradient-to-r from-teal-800 to-gray-900">
    <form
        @submit.prevent="login"
        class="p-8 rounded-lg shadow-md w-full max-w-sm"
    >
      <figure>
        <img
            src="/images/sfb-logo-400x400.webp"
            alt="Super Fantasy Baseball"
            class="rounded-large pb-6"
        />
      </figure>
      <h2>Login</h2>
      <div class="mb-4">
        <label for="username">Username</label>
        <input
            v-model="username"
            id="username"
            placeholder="Username"
            required
            class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
      </div>
      <div class="mb-6">
        <label for="password">Password</label>
        <input
            v-model="password"
            id="password"
            type="password"
            placeholder="Password"
            required
            class="w-full p-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
      </div>
      <button
          type="submit"
          class="w-full bg-blue-500 text-white p-3 rounded hover:bg-blue-600 transition-colors"
      >
        Login
      </button>
    </form>
  </div>
</template>