<script>
export default {
  created() {
    this.checkAuth();
  },
  methods: {
    async checkAuth() {
      const token = localStorage.getItem('sfb-auth-jwt');
      const wphost = import.meta.env.VITE_LOCAL_HOST;
      const validateTokenEndpoint = import.meta.env.VITE_WP_AUTH_ENDPOINT_VALIDATE;
      const authRequestURI = `${wphost}/${validateTokenEndpoint}`;

      if (token) {
        try {
          const response = await fetch(authRequestURI, {
            method: 'POST',
            headers: {
              'Authorization': `Bearer ${token}`,
            },
          });

          if (response.ok) {
            console.log('validated')
            await this.$router.push('/home');
          } else {
            new Error('Token is invalid');
          }
        } catch (error) {
          localStorage.removeItem('sfb-auth-jwt');
          await this.$router.push('/login');
        }
      } else {
        await this.$router.push('/login');
      }
    },
  },
};
</script>

<template>
  <main class="login-loading">
    <p>Loading...</p>
  </main>
</template>

<style scoped>
/* Fun loader pending */
</style>