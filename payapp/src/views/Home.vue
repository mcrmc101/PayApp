<template>
  <div class="home">

    <b-row>
      <h2 class="gtext">Card Payments for small business</h2>
    </b-row>
    <hr>
    <b-row
      align-v="center"
      align-h="center"
    >
      <b-col md="8">
        <p>Tired of paying to rent a card machine? Bored of paying inflated fees just to take payments? Then <strong>PayApp</strong> is for you! <br>
          Using Stripe.com, we provide a simple solution to take card or phone payments from customers. Simply enter a customers email address and a secure payment form is sent for them to fill out on their own device. No more cumbersome card machines or high rental fees. Just do the work and take the payment.
        </p>
      </b-col>
      <b-col
        class="text-center"
        md="4"
      >
        <img
          src="/img/icons/android-chrome-512x512.png"
          alt="PayApp Icon"
          style="max-height:20vh;"
        />
      </b-col>
    </b-row>
    <hr>
    <b-row>
      <b-col>
        <h4>How It works:</h4>
        <ol>
          <li>Enter the Customers name, Email address and the Amount you would like to charge.</li>
          <li>The Customer recieves a link to the payment form in their emails.</li>
          <li>The Customer fills out the payment form, using a credit or debit card or Apple or Google Pay if enabled on their device.</li>
          <li>Payments are made into your bank account via Stripe.</li>
        </ol>
      </b-col>
    </b-row>
    <hr>
    <b-row>
      <b-col>
        <h4>What You'll Need:</h4>
        <ol>
          <li>PayApp is a service for businesses. You'll need to be registered as a business and signed up to pay tax in the loactions you operate</li>
          <li>You'll need a Stripe Account. Stripe will verify your identity and monitor your account for signs of fraud, money laundering etc</li>
          <li>You'll need a phone or other device capable to accessing the internet. Your customers must have an active email address to receive the payment form.</li>
        </ol>
      </b-col>
    </b-row>
    <hr>
    <b-row>
      <b-col>
        <h4>Interested?</h4>
        <p>Send us a message using the form below and we'll have a chat about getting you set up. Remember, you have to be a registered business and you need a stripe account to use PayApp</p>
      </b-col>
    </b-row>
    <b-card>
      <contact-form></contact-form>
    </b-card>
  </div>
</template>

<script>
import ContactForm from '../components/home/ContactForm.vue'
export default {
  name: 'Home',
  components: {
    ContactForm
  },
  created () {

  }
}
</script>
