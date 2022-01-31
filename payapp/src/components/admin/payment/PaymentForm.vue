<template>
  <div>
    <b-spinner
      variant="success"
      label="Spinning"
      v-if="isLoading"
    ></b-spinner>
    <b-form
      @submit.prevent="onNewPayment"
      ref="newpayment"
      v-else
    >
      <b-row
        align-v="center"
        align-h="center"
      >
        <h2 class="dtext">New Payment:</h2>
        <hr>
      </b-row>
      <b-row
        align-v="center"
        align-h="center"
      >
        <b-col md="6">
          <b-card class="m-2">
            <b-form-group
              label="Customer Name:"
              label-for="cusname"
            >
              <b-form-input
                v-model="cusname"
                id="cusname"
                required
              ></b-form-input>
            </b-form-group>
          </b-card>
        </b-col>
        <b-col md="6">
          <b-card class="m-2">
            <b-form-group
              label="Customer Email:"
              label-for="cusemail"
            >
              <b-form-input
                v-model="cusemail"
                id="cusemail"
                type="email"
                required
              ></b-form-input>
            </b-form-group>
          </b-card>
        </b-col>
      </b-row>
      <b-row
        align-v="center"
        align-h="center"
      >
        <b-col md="6">
          <b-card class="m-2">
            <b-form-group
              label="Amount:"
              label-for="amount"
            >
              <b-form-input
                v-model="amount"
                id="amount"
                type="number"
                step="0.01"
                placeholder="£"
                required
              ></b-form-input>
            </b-form-group>
          </b-card>
        </b-col>
        <b-col md="6">
          <div class="m-2">
            <b-form-group class="text-center">
              <br>
              <b-button
                type="submit"
                variant="success"
                size="lg"
              >Create Payment Form</b-button>
            </b-form-group>
          </div>
        </b-col>
      </b-row>
    </b-form>
  </div>
</template>
<script>
import axios from 'axios'
export default {
  name: 'PaymentForm',
  data () {
    return {
      cusname: '',
      cusemail: '',
      amount: '',
      isLoading: false
    }
  },
  methods: {
    onNewPayment: function () {
      this.isLoading = true
      var data = {
        'cname': this.cusname,
        'cemail': this.cusemail,
        'amount': this.amount,
      }
      axios.post('https://payapp.mcrmc.co.uk/api/newPayment', data, {
        headers: {
          Authorization: `Bearer ${this.$store.state.userToken}`
        }
      })
        .then((res) => {
          if (res.status === 500 || res.status === 401) {
            this.$store.commit('setIsUser', false)
            this.flashMessage.show({
              status: 'error',
              title: 'Token Expired!',
              message: 'Please Log In Again!',
              time: 4000
            })
            this.$router.push({ name: 'Login' })
          }
          this.flashMessage.show({
            status: 'success',
            title: 'Payment Form Emailed!',
            time: 4000
          })
          this.$refs.newpayment.reset()
          this.isLoading = false
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
            time: 3500
          });
        })
    }
  }
}
</script>