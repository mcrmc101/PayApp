<template>
  <b-form @submit.prevent="onLogin">
    <b-row>
      <h2 class="dtext">Login</h2>
      <hr>
    </b-row>
    <b-row
      align-v="center"
      align-h="center"
    >
      <b-col
        cols="12"
        md="6"
      >
        <b-form-group
          id="emailinputgroup"
          label-for="emailinput"
          label="Email Address"
        >
          <b-form-input
            type="email"
            v-model="useremail"
            id="emailinput"
          ></b-form-input>
        </b-form-group>
      </b-col>
      <b-col
        cols="12"
        md="6"
      >
        <b-form-group
          id="passwordinputgroup"
          label-for="passwordinput"
          label="Password"
        >
          <b-form-input
            type="password"
            v-model="userpassword"
            id="passwordinput"
          ></b-form-input>
        </b-form-group>
      </b-col>
    </b-row>
    <b-row class="pt-2">
      <b-col>
        <b-button
          type="submit"
          variant="success"
        >Submit</b-button>
      </b-col>
    </b-row>
  </b-form>
</template>
<script>
import axios from 'axios'
export default {
  name: 'LoginForm',
  data () {
    return {
      useremail: '',
      userpassword: ''
    }
  },
  methods: {
    onLogin: function () {
      var data = {
        'email': this.useremail,
        'password': this.userpassword,
      }
      axios.post('https://payapp.mcrmc.co.uk/api/api/login', data)
        .then((response) => {
          console.log(response.data.user.is_activated)
          this.$store.commit('setUserToken', response.data.token)
          if (response.data.user.is_activated === false) {
            this.$router.push({ name: 'Activate' });
          }
          else {
            this.$store.commit('setIsUser', true)
            this.flashMessage.show({
              status: 'success',
              title: 'Logged In',
              time: 2500
            })
            this.$router.push({ name: 'Admin' });
          }
        })
        .catch((error) => {
          console.log(error)
          var errorarr = error.response.data.error;
          var n = Object.values(errorarr);
          var err = n.toString().replace("[^0-9a-zA-Z]+", "").replace(/,/g, '');
          this.flashMessage.show({
            status: 'error',
            title: 'Error!',
            message: err,
            time: 2500
          });
        })
    }
  }
}
</script>