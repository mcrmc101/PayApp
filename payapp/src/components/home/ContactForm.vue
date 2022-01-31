<template>
  <div>
    <b-form
      ref="contactform"
      @submit.prevent="newContact"
    >
      <b-form-row
        align-h="center"
        align-v="end"
        class="mb-2"
      >
        <b-col>
          <b-form-group
            label="Your Name"
            label-for="name"
          >
            <b-form-input
              id="name"
              v-model="name"
              required
            ></b-form-input>
          </b-form-group>
        </b-col>
        <b-col>
          <b-form-group
            label="Your Email"
            label-for="email"
          >
            <b-form-input
              id="email"
              v-model="email"
              required
            ></b-form-input>
          </b-form-group>
        </b-col>
      </b-form-row>
      <b-form-row
        align-h="center"
        align-v="end"
        class="mb-2"
      >
        <b-col>
          <b-form-group
            label="Please tell us about your business"
            label-for="message"
          >
            <b-form-textarea
              id="message"
              v-model="message"
            ></b-form-textarea>
          </b-form-group>
        </b-col>
        <b-col>
          <b-form-group>
            <b-button
              type="submit"
              variant="success"
              class="mt-2"
            >Send</b-button>
          </b-form-group>
        </b-col>
      </b-form-row>
    </b-form>
  </div>
</template>
<script>
import axios from 'axios'
export default {
  name: 'ContactForm',
  data () {
    return {
      name: '',
      email: '',
      message: '',
    }
  },
  methods: {
    newContact: function () {
      var data = {
        'cname': this.name,
        'cemail': this.email,
        'message': this.message,
      }
      axios.post('https://payapp.mcrmc.co.uk/api/newContact', data)
        .then((res) => {
          console.log(res)
          this.flashMessage.show({
            status: 'success',
            title: 'Thank You',
            message: 'Your Message Has Been Sent!',
            time: 4000
          })
          this.$refs.contactform.reset()
        })
        .catch((error) => {
          console.log(error)
        })
    }
  }
}
</script>