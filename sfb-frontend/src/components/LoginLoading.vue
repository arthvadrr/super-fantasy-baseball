<script>
export default {
  created() {
    this.checkAuth();
  },
  methods: {
    async checkAuth() {
      const token = localStorage.getItem('sfb-auth-jwt');
      const wphost = '';
      const authEndpoint = '';
      const authRequestURI = `${wphost}/${authEndpoint}`;

      if (token) {
        try {
          const response = await fetch(authRequestURI, {
            method: 'POST',
            headers: {
              'Authorization': `Bearer ${token}`,
            },
          });

          if (response.ok) {
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