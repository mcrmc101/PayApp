<template>
  <div>
    <b-row
      align-v="center"
      align-h="center"
      class="m-2"
    >
      <h2 class="dtext">All Payments:</h2>
      <hr>
    </b-row>
    <b-row
      align-v="center"
      align-h="center"
      class="mb-2"
    >
      <payments-not-paid></payments-not-paid>
    </b-row>
    <hr>
    <b-row
      align-v="center"
      align-h="center"
      class="mb-2"
    >
      <payments-paid></payments-paid>
    </b-row>
  </div>
</template>
<script>
import PaymentsNotPaid from './PaymentsNotPaid.vue'
import PaymentsPaid from './PaymentsPaid.vue'
export default {
  name: 'Archive',
  components: { PaymentsNotPaid, PaymentsPaid }
}
</script>