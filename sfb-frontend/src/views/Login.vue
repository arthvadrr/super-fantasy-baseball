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
      function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);

        if (parts.length === 2) {
          return parts.pop().split(';').shift();
        }

        return null;
      }

      try {
        const HOST = import.meta.env.VITE_LOCAL_HOST;
        const ENDPOINT_LOGIN = import.meta.env.VITE_ENDPOINT_LOGIN;
        const ENDPOINT_CSRF = import.meta.env.VITE_ENDPOINT_CSRF;
        const REQUEST_URI = `${HOST}/${ENDPOINT_LOGIN}`;
        const CSRF_URI = `${HOST}/${ENDPOINT_CSRF}`;
        let csrf_cookie;

        try {
          const data = await fetch(CSRF_URI, {
            method: 'GET',
            credentials: 'include',
          });

          csrf_cookie = getCookie('XSRF-TOKEN');
        } catch (error) {
          throw new Error('Failed to retrive CSRF token', error);
        }

        console.log(csrf_cookie);

        const response = await fetch(REQUEST_URI, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-XSRF-TOKEN': csrf_cookie,
          },
          body: JSON.stringify({
            email: this.email,
            password: this.password,
          }),
        });

        console.log('response', response);

        if (response.ok) {
          const data = await response.json();

          if (token) {
            localStorage.setItem('sfb-auth-jwt', token);
            await this.$router.push('/dashboard');
          } else {
            new Error('Token not found in response');
          }
        } else {
          alert('Login failed. Please check your credentials.');
        }
      } catch (error) {
        console.log('Login error:', error);
      }
    },
  },
};
</script>

<template>
  <div class="login flex items-center justify-center flex-col min-h-screen">
    <form @submit.prevent="login" class="w-full max-w-sm">
      <div
        class="flex-col items-center text-center form-inner shadow-md bg-white m-3 rounded-2xl border-4 border-sfb-brown"
      >
        <h1
          class="flex items-center rounded-2xl justify-center flex-col text-3xl scoped-template-h1 pr-3 pl-3 pb-1 pt-3 text-center"
        >
          <small class="text-sm">Welcome to</small>
          <span class="pb-2 w-100">Super Fantasy Baseball</span>
        </h1>
        <figure>
          <img
            src="/images/sfb-logo-800x800.webp"
            alt="Super Fantasy Baseball"
            class="pb-8 rounded-sfb-l"
          />
        </figure>
        <div class="pr-6 pl-6 text-start mb-4">
          <div class="mb-3">
            <label for="username">Username</label>
            <input
              v-model="username"
              id="username"
              placeholder="Username"
              required
              class="w-full p-2 border border-gray-300 rounded-l focus:outline-none focus:ring-2 focus:ring-blue-500 bg-sfb-input-bg"
            />
          </div>
          <div class="mb-3">
            <label for="password">Password</label>
            <input
              v-model="password"
              id="password"
              type="password"
              placeholder="Password"
              required
              class="w-full p-2 border border-gray-300 rounded-l focus:outline-none focus:ring-2 focus:ring-blue-500 bg-sfb-input-bg"
            />
          </div>
        </div>
        <button type="submit" class="scoped-template-submit">Log In</button>

        <div
          class="flex items-center justify-center flex-col mb-4 text-sfb-link underline"
        >
          <a href="#" class="mb-1">Reset password</a>
          <a href="#" class="mb-4">Create an account</a>
        </div>
      </div>
    </form>
  </div>
</template>

<style lang="scss" scoped>
@use '../assets/styles/variables' as *;

.scoped-template-h1 {
  background-image: linear-gradient(to bottom, #ffffff, $sfb-blue 30%);
  padding-bottom: 8rem;

  span {
    text-shadow: $sfb-brown 1px 1px 1px;
  }
}

.scoped-template-submit {
  background-image: linear-gradient(to right, #f5b165, #de564d);
  padding: 0.5rem 4rem;
  border: 2px solid $sfb-brown;
  border-radius: 0.25rem;
  color: #fff;
  text-shadow: #000 1px 1px 1px;
  font-weight: 700;
  margin-bottom: 1rem;
  transition: filter 200ms, border-color 80ms;

  &:hover,
  &:focus {
    filter: brightness(1.2);
  }

  &:active {
    filter: brightness(1.2) hue-rotate(150deg);
  }
}

figure {
  margin: -1.4rem;
  margin-top: -8rem;
}
</style>
