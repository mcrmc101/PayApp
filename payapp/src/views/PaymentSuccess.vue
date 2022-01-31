<template>
  <div>
    <div v-if="firstLoad">
      <b-row
        align-v="center"
        align-h="center"
      >
        <b-card title="Payment Successful">
          <hr>
          <b-card-text>
            <strong>Thank You!</strong> <br>Your payment to {{ this.name }} for £{{ this.amount }} has been successful. You can close this page any time. Thank you for using PayApp.
            <br>
            <br>
            <strong>Any Problems?</strong>
            <br>
            click <a :href="'mailto:'+this.email">here</a> to email {{ this.name }}
          </b-card-text>
        </b-card>
      </b-row>
    </div>
    <div v-else>
      <hr>
      <b-row
        align-v="center"
        align-h="center"
      >
        <b-col>
          <h2>This Payment has been completed</h2>
          <p>This transaction has already been processed. Please contact {{ this.name }} if you need a new payment form or close this page if you have already completed your payment.</p>
        </b-col>
      </b-row>
    </div>
  </div>
</template>
<script>
import axios from 'axios'
export default {
  name: 'PaymentSuccess',
  data () {
    return {
      name: '',
      amount: '',
      email: '',
      firstLoad: true
    }
  },
  created () {
    var data = {
      'cs': this.$route.query.payment_intent_client_secret
    }
    axios.post('https://payapp.mcrmc.co.uk/api/paymentSuccess', data)
      .then((res) => {
        this.name = res.data.success.name
        this.amount = res.data.success.amount
        this.email = res.data.success.email
      })
      .catch(() => {
        this.firstLoad = false
        return
      })

  }
}
</script>