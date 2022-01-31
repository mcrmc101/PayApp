<template>
  <div>
    <b-form
      @submit.prevent="onUpdateStripe"
      ref="stripeform"
    >
      <b-row
        align-v="center"
        align-h="center"
        class="m-2"
      >
        <h2 class="dtext">Stripe Admin:</h2>
        <b-alert
          variant="warning"
          show
          v-if="this.islive == 0"
        >PayApp is in Test Mode</b-alert>
        <b-alert
          variant="success"
          show
          v-else
        >PayApp is in Live Mode</b-alert>
        <hr>
        <small>Copy your API keys from your Stripe Dashboard and paste them here</small>
      </b-row>
      <b-row
        align-h="center"
        align-v="center"
      >
        <b-col md="6">
          <b-card class="m-2">
            <b-form-group
              label="Live Publishable API Key"
              label-for="pkey"
            >
              <b-form-input
                v-model="pkey"
                id="pkey"
                required
              ></b-form-input>
            </b-form-group>
          </b-card>
        </b-col>
        <b-col md="6">
          <b-card class="m-2">
            <b-form-group
              label="Live Secret API Key"
              label-for="skey"
            >
              <b-form-input
                v-model="skey"
                id="skey"
                required
              ></b-form-input>
            </b-form-group>
          </b-card>
        </b-col>
      </b-row>
      <b-row
        align-h="center"
        align-v="center"
      >
        <b-col md="6">
          <b-card class="m-2">
            <b-form-group
              label="Test Publishable API Key"
              label-for="pkey_test"
            >
              <b-form-input
                v-model="pkey_test"
                id="pkey_test"
                required
              ></b-form-input>
            </b-form-group>
          </b-card>
        </b-col>
        <b-col md="6">
          <b-card class="m-2">
            <b-form-group
              label="Test Secret API Key"
              label-for="skey_test"
            >
              <b-form-input
                v-model="skey_test"
                id="skey_test"
                required
              ></b-form-input>
            </b-form-group>
          </b-card>
        </b-col>
      </b-row>

      <b-row
        align-h="center"
        align-v="center"
      >
        <b-col md="6">
          <b-card class="m-2">
            <b-form-group
              label="Test Mode?"
              label-for="islive"
            >
              <b-form-select
                v-model="islive"
                id="islive"
                plain
                @change="onUpdateStripe"
              >
                <b-form-select-option value="0">Yes</b-form-select-option>
                <b-form-select-option value="1">No</b-form-select-option>
              </b-form-select>
            </b-form-group>
          </b-card>
        </b-col>
        <b-col md="6">
          <b-form-group class="m-2">
            <b-button
              type="submit"
              variant="success"
              size="lg"
            >Save</b-button>
          </b-form-group>
        </b-col>
      </b-row>
    </b-form>
  </div>
</template>
<script>
import axios from 'axios'
export default {
  name: 'StripeAdmin',
  data () {
    return {
      skey: '',
      pkey: '',
      pkey_test: '',
      skey_test: '',
      islive: ''
    }
  },
  created () {
    axios.get('https://payapp.mcrmc.co.uk/api/getStripeInfo', {
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
        this.skey = res.data.success.skey
        this.pkey = res.data.success.pkey
        this.skey_test = res.data.success.skey_test
        this.pkey_test = res.data.success.pkey_test
        this.islive = res.data.success.islive
      })
      .catch((err) => {
        console.log(err)
      })
  },
  methods: {
    onUpdateStripe: function () {
      var data = {
        'skey': this.skey,
        'pkey': this.pkey,
        'pkeytest': this.pkey_test,
        'skeytest': this.skey_test,
        'islive': this.islive
      }
      axios.post('https://payapp.mcrmc.co.uk/api/updateStripe', data, {
        headers: {
          Authorization: `Bearer ${this.$store.state.userToken}`
        }
      })
        .then((res) => {
          console.log(res)
          this.flashMessage.show({
            status: 'success',
            title: 'Saved!',
            time: 4000
          })
          //this.$refs.stripeform.reset()
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
            time: 3000
          });
        })
    }
  }
}
</script>