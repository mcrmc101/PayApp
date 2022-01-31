<template>
  <div>
    <b-card title="Completed Payments:">
      <hr>
      <b-row>
        <b-table
          :items="items"
          :fields="fields"
          :current-page="currentPage"
          :per-page="perPage"
          show-empty
          small
          responsive="true"
          sort-icon-left
          hover
          sticky-header
          bordered
        ></b-table>
      </b-row>
      <b-row
        align-v="end"
        align-h="center"
      >
        <b-col md="6">
          <b-form-group
            label="Show Rows:"
            label-for="per-page-select"
            label-cols-sm="6"
            label-cols-md="4"
            label-cols-lg="3"
            label-align-sm="right"
            label-size="sm"
            class="mb-0"
          >
            <b-form-select
              id="per-page-select"
              v-model="perPage"
              :options="pageOptions"
              size="sm"
              plain
            ></b-form-select>
          </b-form-group>
        </b-col>
        <b-col md="6">
          <b-pagination
            v-model="currentPage"
            :total-rows="totalRows"
            :per-page="perPage"
            align="fill"
            size="sm"
            class="my-0"
          ></b-pagination>
        </b-col>
      </b-row>
    </b-card>
  </div>
</template>
<script>
import axios from 'axios'
export default {
  name: 'PaymentsPaid',
  data () {
    return {
      totalRows: 1,
      currentPage: 1,
      perPage: 5,
      pageOptions: [5, 10, 25, 50],
      items: [],
      fields: [
        {
          key: 'created_at',
          label: 'Date',
          sortable: true,
          sortDirection: 'desc',
        },
        { key: 'amount', label: 'Amount', sortable: true },
        { key: 'cname', label: 'Customer', sortable: true },
        { key: 'cemail', label: 'Email', sortable: true },
      ]

    }
  },
  created () {
    axios.get('https://payapp.mcrmc.co.uk/api/getPaid', {
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
        this.items = res.data
        this.totalRows = res.data.length
      })
      .catch((error) => {
        console.log(error)
      })
  }
}
</script>