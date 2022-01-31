<template>
  <div>
    <b-row
      align-v="center"
      align-h="center"
    >
      <b-card
        bg-variant="light"
        class="m-2"
      >
        <login-form></login-form>
      </b-card>
      <b-card
        bg-variant="light"
        class="m-2"
      >
        <sign-up-form></sign-up-form>
      </b-card>
    </b-row>
  </div>
</template>
<script>
import LoginForm from '../components/login/LoginForm.vue'
import SignUpForm from '../components/login/SignUpForm.vue'
export default {
  name: 'Login',
  components: { LoginForm, SignUpForm }
}
</script>