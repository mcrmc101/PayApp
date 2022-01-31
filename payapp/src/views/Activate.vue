<template>

  <div class="padme">
    <b-row
      style="height:100vh"
      align-h="center"
      align-v="center"
    >
      <b-card bg-variant="faded">
        <h1>Please wait while your account is activated.</h1>
      </b-card>
    </b-row>
  </div>

</template>
<script>
import axios from 'axios'
export default {
  name: 'Activate',
  data () {
    return {
      int: ''
    }
  },
  mounted () {
    this.int = setInterval(() => {
      this.checkIsActive()
    }, 20000);
  },
  methods: {
    checkIsActive: function () {
      axios.get('http://localhost/xenvue/api/checkActive/', {
        headers: {
          Authorization: `Bearer ${this.$store.state.usertoken}`
        }
      })
        .then((response) => {
          console.log(response.data)
          if (response.data === 1) {
            this.flashMessage.show({
              status: 'success',
              title: 'Your Account Has Been Activated!',
              time: 2500
            })
            this.$store.commit('setisuser', true)
            clearInterval(this.int)
            this.$router.push({ name: 'Admin' })
            return
          }
          else {
            return
          }
        })
        .catch(() => {
          this.$router.push({ name: 'Login' })
        })
    }
  }
}
</script>