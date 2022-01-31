<template>
  <div>
    <div v-if="this.$store.state.isUser">
      <b-card
        no-body
        bg-variant="light"
      >
        <b-tabs
          card
          fill
        >
          <b-tab
            title="New Payment"
            active
          >
            <payment-form></payment-form>
          </b-tab>
          <b-tab title="All Payments">
            <archive></archive>
          </b-tab>
          <b-tab title="Stripe Admin">
            <stripe-admin></stripe-admin>
          </b-tab>
        </b-tabs>
      </b-card>
    </div>
    <div v-else>
      <h1>Not Authorised!</h1>
    </div>
  </div>
</template>
<script>
import axios from 'axios'
import PaymentForm from '../components/admin/payment/PaymentForm.vue'
import StripeAdmin from '../components/admin/stripe/StripeAdmin.vue'
import Archive from '../components/admin/archive/Archive.vue'
export default {
  name: 'Admin',
  components: { PaymentForm, StripeAdmin, Archive },
  created () {
    this.checkIsUser()
  },
  methods: {
    checkIsUser: function () {
      axios.get('https://payapp.mcrmc.co.uk/api/getAuthenticatedUser', {
        headers: {
          Authorization: `Bearer ${this.$store.state.userToken}`
        }
      })
        .then(() => {
          this.$store.commit('setIsUser', true)
          return
        })
        .catch(() => {
          this.$store.commit('setIsUser', false)
          this.$router.push({ name: 'Login' })
        })
    }
  }
}
</script>