<template>
    <div class="card">
        <div class="card-header">
            <i class="fa fa-plus"></i>
            Tambah Pendistribusian Zakat
        </div>

        <div class="card-body">
            <form @submit.prevent="onFormSubmit">
                <div class='form-group'>
                    <label for='transaction_date'> Tanggal Transaksi: </label>
                    <input
                        v-model='transaction_date'
                        class='form-control'
                        :class="{'is-invalid': get(this.error_data, 'errors.transaction_date[0]', false)}"
                        type='date' id='transaction_date' placeholder='Tanggal Transaksi'>
                    <div class='invalid-feedback'>{{ get(this.error_data, 'errors.transaction_date[0]', false) }}</div>
                </div>

                <div class="form-group">
                    <label for="amount"> Nominal: </label>

                    <vue-cleave
                        class="form-control"
                        v-model.number="amount"
                        :options="{ numeral: true, numeralDecimalMark: ',', delimiter: '.' }" />
                </div>

                <div class="form-group">
                    <label for="mustahiq"> Mustahik: </label>
                    <multiselect
                        track-by="id"
                        label="name"
                        :options="mustahiqs"
                        v-model="mustahiq"
                        :preselect-first="true"
                        />
                </div>

                <div class="text-right">
                    <button class="btn btn-primary">
                        Tambah Pendistribusian Zakat
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { get } from 'lodash'
import Multiselect from 'vue-multiselect'
import VueCleave from 'vue-cleave-component'

export default {
    components: { Multiselect, VueCleave },

    props: [
        "submit_url", "redirect_url",
        "mustahiqs"
    ],

    data() {
        return {
            transaction_date: null,
            amount: null,
            mustahiq: null,
            error_data: null
        }
    },

    computed: {
        form_data() {
            return {
                transaction_date: this.transaction_date,
                amount: this.amount,
                mustahiq_id: get(this.mustahiq, "id", null),
            }
        }
    },

    methods: {
        get: get,

        onFormSubmit(e) {
            axios.post(this.submit_url, this.form_data)
               .then(response => {
                    window.location.replace(this.redirect_url)
               })
               .catch(error => {
                   this.error_data = error.response.data
               })
        }
    },
}
</script>
