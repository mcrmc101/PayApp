<template>
  <div id="app">
    <FlashMessage class="fixed-top"></FlashMessage>
    <b-navbar
      variant="faded"
      type="light"
    >
      <b-navbar-brand tag="h1"><img
          src="/img/payapplogo1.png"
          alt="PayApp Logo"
          style="max-height:10vh;"
          class="ms-5"
        /></b-navbar-brand>
    </b-navbar>
    <b-container>
      <router-view />
    </b-container>
    <b-row
      align-h="center"
      align-v="center"
      class="m-4 text-center"
    >
      <b-col
        md="8"
        class="m-2"
      >
        <small class="dtext">PayApp &copy;{{ this.year }} <a href="https://mcrmc.co.uk">mcrmc.co.uk</a></small>
      </b-col>
      <b-col
        md="4"
        class="m-2"
      >
        <router-link
          to="Admin"
          v-if="this.$store.state.isUser"
        >Admin</router-link>
        <router-link
          to="Login"
          v-else
        >Login</router-link>
      </b-col>
    </b-row>
  </div>
</template>
<script>
export default {
  data () {
    return {
      year: new Date().getFullYear()
    }
  }
}
</script>

<style>
@import url("https://fonts.googleapis.com/css2?family=Oxygen&display=swap");

.sr-only {
  display: none !important;
}
#app {
  font-family: "Oxygen", sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  background-color: rgba(245, 245, 245, 0.5);
}

.dtext {
  color: rgba(32, 53, 124, 0.9);
  font-weight: bold;
}

.gtext {
  color: rgba(80, 101, 168, 0.9);
}

.brandbg {
  background-color: rgba(32, 53, 124, 0.9);
}
</style>
