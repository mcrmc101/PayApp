<template>
  <b-form @submit.prevent="onSignUp">
    <b-row align-h="center">
      <h2 class="dtext">Sign Up</h2>
      <hr>
      <!--<b-button @click.prevent="onTestuser">Test!</b-button>-->
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
          id="signupusernameinputgroup"
          label-for="signupusernameinput"
          label="User Name"
        >
          <b-form-input
            v-model="username"
            id="signupusernameinput"
          ></b-form-input>
        </b-form-group>
      </b-col>
      <b-col
        cols="12"
        md="6"
      >
        <b-form-group
          id="signupemailinputgroup"
          label-for="signupemailinput"
          label="Email Address"
        >
          <b-form-input
            type="email"
            v-model="useremail"
            id="signupemailinput"
          ></b-form-input>
        </b-form-group>
      </b-col>
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
          id="signuppasswordinputgroup"
          label-for="signuppassword"
          label="Enter Your Password"
        >
          <b-form-input
            type="password"
            v-model="userpassword"
            id="signuppassword"
          ></b-form-input>
        </b-form-group>
      </b-col>
      <b-col
        cols="12"
        md="6"
      >
        <b-form-group
          id="signuppasswordconfirminputgroup"
          label-for="signuppasswordconfirm"
          label="Confirm Your Password"
        >
          <b-form-input
            type="password"
            v-model="userpasswordconfirm"
            id="signuppasswordconfirm"
          ></b-form-input>
        </b-form-group>
      </b-col>
    </b-row>
    <b-row class="pt-2">
      <b-col>
        <b-button
          type="submit"
          variant="success"
        >Sign Up</b-button>
      </b-col>
    </b-row>
  </b-form>
</template>
<script>
import axios from 'axios'
export default {
  name: 'SignUpForm',
  data () {
    return {
      username: '',
      useremail: '',
      userpassword: '',
      userpasswordconfirm: '',
    }
  },
  methods: {

    onTestuser: function () {
      axios.get('https://payapp.mcrmc.co.uk/api/getAuthenticatedUser', {
        headers: {
          Authorization: `Bearer ${this.$store.state.userToken}`
        }
      })
        .then((response) => {
          console.log(response)
        })
        .catch((error) => {
          console.log(error)
        })
    },
    onSignUp: function () {
      var data = {
        'name': this.username,
        'email': this.useremail,
        'password': this.userpassword,
        'password_confirmation': this.userpasswordconfirm
      }
      axios.post('https://payapp.mcrmc.co.uk/api/api/signup', data)
        .then((response) => {
          console.log(response)
          this.$store.commit('settoken', response.data.token)
          if (response.data.user.is_activated === true) {
            this.$store.commit('setisuser', true)
          }
          this.flashMessage.show({
            status: 'success',
            title: 'Signed Up. Please Wait for your Account to be Activated',
            time: 2500
          })
          this.$router.push({ name: 'Activate' })
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