<template>
    <div class="card">
        <div class="card-header">
            <i class="fa fa-pencil"></i>
            Sunting Penerimaan Zakat
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
                    <label for="zakat"> Zakat: </label>

                    <vue-cleave
                        class="form-control"
                        v-model.number="zakat"
                        :class="{'is-invalid': get(this.error_data, 'errors.zakat[0]', false)}"
                        :options="{ numeral: true, numeralDecimalMark: ',', delimiter: '.' }" />

                    <div class='invalid-feedback'>{{ get(this.error_data, 'errors.zakat[0]', false) }}</div>
                </div>

                <div class="form-group">
                    <label for="fitrah"> Fitrah: </label>

                    <vue-cleave
                        class="form-control"
                        :class="{'is-invalid': get(this.error_data, 'errors.fitrah[0]', false)}"
                        v-model.number="fitrah"
                        :options="{ numeral: true, numeralDecimalMark: ',', delimiter: '.' }" />

                    <div class='invalid-feedback'>{{ get(this.error_data, 'errors.fitrah[0]', false) }}</div>
                </div>


                <div class="form-group">
                    <label for="infak"> Infak: </label>

                    <vue-cleave
                        class="form-control"
                        :class="{'is-invalid': get(this.error_data, 'errors.infak[0]', false)}"
                        v-model.number="infak"
                        :options="{ numeral: true, numeralDecimalMark: ',', delimiter: '.' }" />

                    <div class='invalid-feedback'>{{ get(this.error_data, 'errors.infak[0]', false) }}</div>
                </div>


                <div class="form-group">
                    <label for="muzakki"> Muzakki: </label>
                    <multiselect
                        track-by="id"
                        :custom-label="({name, nik}) => `${name} (${nik})`"
                        :options="muzakkis"
                        v-model="muzakki"
                        :preselect-first="true"
                        />
                </div>

                <div class="text-right">
                    <button class="btn btn-primary">
                        Perbarui Data
                        <i class="fa fa-check"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { get } from 'lodash'
import moment from 'moment'
import Multiselect from 'vue-multiselect'
import VueCleave from 'vue-cleave-component'

export default {
    components: { Multiselect, VueCleave },

    props: [
        "submit_url", "redirect_url",
        "muzakkis", "receivement"
    ],

    data() {
        return {
            transaction_date: moment(this.receivement.transaction_date).format("YYYY-MM-DD"),
            zakat: this.receivement.zakat,
            fitrah: this.receivement.fitrah,
            infak: this.receivement.infak,
            muzakki: this.muzakkis.find(muzakki => muzakki.id === this.receivement.muzakki_id),
            error_data: null
        }
    },

    computed: {
        form_data() {
            return {
                transaction_date: this.transaction_date,
                zakat: this.zakat,
                fitrah: this.fitrah,
                infak: this.infak,
                muzakki_id: get(this.muzakki, "id", null),
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
