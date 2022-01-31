<template>
  <div>
    <hr>
    <div v-if="notpaid">
      <b-row
        align-v="center"
        align-h="center"
        class="m-2"
      >
        <b-col md="6">
          <h4>Payment request from {{ this.$route.query.name }} for £{{ this.$route.query.amount }}</h4>
        </b-col>
        <b-col md="6">
          <small>All Payments are handled securely by <a href="https://stripe.com">Stripe.com</a></small>
        </b-col>
      </b-row>
      <hr>
      <b-row
        align-v="center"
        align-h="center"
        class="m-2"
      >
        <form id="payment-form">
          <div id="payment-element">
            <!--Stripe.js injects the Payment Element-->
          </div>
          <button
            id="submit"
            variant="success"
          >
            <div
              class="spinner hidden"
              id="spinner"
            ></div>
            <span id="button-text">Pay £{{ this.$route.query.amount }}</span>
          </button>

          <div
            id="payment-message"
            class="hidden"
          ></div>
        </form>
      </b-row>
    </div>
    <div v-else>
      <hr>
      <b-row>
        <b-col>
          <h2>This Payment has been completed</h2>
          <p>This transaction has already been processed. Please contact {{ this.$route.query.name }} if you need a new payment form or close this page if you have already completed your payment.</p>
        </b-col>
      </b-row>
    </div>
  </div>
</template>
<script>
import axios from 'axios'

export default {
  name: 'Payment',
  components: {},
  data () {
    return {
      pk: this.$route.query.pk,
      options: '',
      stripe: window.Stripe(String(this.$route.query.pk)),
      elements: '',
      notpaid: true

    }
  },
  mounted: function () {
    var cs
    var data = {
      'paycode': this.$route.query.paycode
    }
    axios.post('https://payapp.mcrmc.co.uk/api/getPaymentInfo', data)
      .then((res) => {
        cs = res.data.success
        console.log(cs)
        this.options = {
          clientSecret: cs
        }
        this.initialize();
        this.checkStatus();
        document
          .querySelector("#payment-form")
          .addEventListener("submit", this.handleSubmit);
      })
      .catch(() => {
        this.notpaid = false
        return
      })

  },
  methods: {
    initialize: async function () {
      this.elements = this.stripe.elements(this.options);
      const paymentElement = this.elements.create("payment");
      paymentElement.mount("#payment-element");
    },
    handleSubmit: async function (e) {
      var elements = this.elements
      e.preventDefault();
      this.setLoading(true);
      const { error } = this.stripe.confirmPayment({
        elements,
        confirmParams: {
          // Make sure to change this to your payment completion page
          return_url: "https://payapp.mcrmc.co.uk/paymentsuccess",
        },
      });

      // This point will only be reached if there is an immediate error when
      // confirming the payment. Otherwise, your customer will be redirected to
      // your `return_url`. For some payment methods like iDEAL, your customer will
      // be redirected to an intermediate site first to authorize the payment, then
      // redirected to the `return_url`.
      if (error.type === "card_error" || error.type === "validation_error") {
        this.showMessage(error.message);
      } else {
        this.showMessage("An unexpected error occured.");
      }

      this.setLoading(false);
    },
    checkStatus: async function () {
      const clientSecret = new URLSearchParams(window.location.search).get(
        "payment_intent_client_secret"
      );

      if (!clientSecret) {
        return;
      }

      const { paymentIntent } = await this.stripe.retrievePaymentIntent(clientSecret);

      switch (paymentIntent.status) {
        case "succeeded":
          this.showMessage("Payment succeeded!");
          break;
        case "processing":
          this.showMessage("Your payment is processing.");
          break;
        case "requires_payment_method":
          this.showMessage("Your payment was not successful, please try again.");
          break;
        default:
          this.showMessage("Something went wrong.");
          break;
      }
    },
    showMessage: function (messageText) {
      const messageContainer = document.querySelector("#payment-message");

      messageContainer.classList.remove("hidden");
      messageContainer.textContent = messageText;

      setTimeout(function () {
        messageContainer.classList.add("hidden");
        messageText.textContent = "";
      }, 4000);
    },
    setLoading: function (isLoading) {
      if (isLoading) {
        // Disable the button and show a spinner
        document.querySelector("#submit").disabled = true;
        document.querySelector("#spinner").classList.remove("hidden");
        document.querySelector("#button-text").classList.add("hidden");
      } else {
        document.querySelector("#submit").disabled = false;
        document.querySelector("#spinner").classList.add("hidden");
        document.querySelector("#button-text").classList.remove("hidden");
      }
    }
  }

}
</script>

<style scoped>
/* Variables */
* {
  box-sizing: border-box;
}

body {
  font-family: -apple-system, BlinkMacSystemFont, sans-serif;
  font-size: 16px;
  -webkit-font-smoothing: antialiased;
  display: flex;
  justify-content: center;
  align-content: center;
  height: 100vh;
  width: 100vw;
}

form {
  width: 30vw;
  min-width: 500px;
  align-self: center;
  box-shadow: 0px 0px 0px 0.5px rgba(50, 50, 93, 0.1),
    0px 2px 5px 0px rgba(50, 50, 93, 0.1), 0px 1px 1.5px 0px rgba(0, 0, 0, 0.07);
  border-radius: 7px;
  padding: 40px;
}

.hidden {
  display: none;
}

#payment-message {
  color: rgb(105, 115, 134);
  font-size: 16px;
  line-height: 20px;
  padding-top: 12px;
  text-align: center;
}

#payment-element {
  margin-bottom: 24px;
}

/* Buttons and links */
button {
  background: #5469d4;
  font-family: Arial, sans-serif;
  color: #ffffff;
  border-radius: 4px;
  border: 0;
  padding: 12px 16px;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  display: block;
  transition: all 0.2s ease;
  box-shadow: 0px 4px 5.5px 0px rgba(0, 0, 0, 0.07);
  width: 100%;
}
button:hover {
  filter: contrast(115%);
}
button:disabled {
  opacity: 0.5;
  cursor: default;
}

/* spinner/processing state, errors */
.spinner,
.spinner:before,
.spinner:after {
  border-radius: 50%;
}
.spinner {
  color: #ffffff;
  font-size: 22px;
  text-indent: -99999px;
  margin: 0px auto;
  position: relative;
  width: 20px;
  height: 20px;
  box-shadow: inset 0 0 0 2px;
  -webkit-transform: translateZ(0);
  -ms-transform: translateZ(0);
  transform: translateZ(0);
}
.spinner:before,
.spinner:after {
  position: absolute;
  content: "";
}
.spinner:before {
  width: 10.4px;
  height: 20.4px;
  background: #5469d4;
  border-radius: 20.4px 0 0 20.4px;
  top: -0.2px;
  left: -0.2px;
  -webkit-transform-origin: 10.4px 10.2px;
  transform-origin: 10.4px 10.2px;
  -webkit-animation: loading 2s infinite ease 1.5s;
  animation: loading 2s infinite ease 1.5s;
}
.spinner:after {
  width: 10.4px;
  height: 10.2px;
  background: #5469d4;
  border-radius: 0 10.2px 10.2px 0;
  top: -0.1px;
  left: 10.2px;
  -webkit-transform-origin: 0px 10.2px;
  transform-origin: 0px 10.2px;
  -webkit-animation: loading 2s infinite ease;
  animation: loading 2s infinite ease;
}

@-webkit-keyframes loading {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes loading {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

@media only screen and (max-width: 600px) {
  form {
    width: 80vw;
    min-width: initial;
  }
}
</style>
