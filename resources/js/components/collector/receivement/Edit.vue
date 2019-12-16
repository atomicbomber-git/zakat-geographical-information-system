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
                        type='text'
                        id='transaction_date'
                        placeholder='Tanggal Transaksi'>
                    <div class='invalid-feedback'>
                         {{ get(this.error_data, 'errors.transaction_date[0]', false) }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='zakat'> Zakat Mal: </label>
                    <input
                        v-model='zakat'
                        class='form-control'
                        :class="{'is-invalid': get(this.error_data, 'errors.zakat[0]', false)}"
                        type='text'
                        id='zakat'
                        placeholder='Zakat Mal'>
                    <div class='invalid-feedback'>
                         {{ get(this.error_data, 'errors.zakat[0]', false) }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='fitrah'> Zakat Fitrah (Tunai): </label>
                    <input
                        v-model='fitrah'
                        class='form-control'
                        :class="{'is-invalid': get(this.error_data, 'errors.fitrah[0]', false)}"
                        type='text'
                        id='fitrah'
                        placeholder='Zakat Fitrah (Tunai)'>
                    <div class='invalid-feedback'>
                         {{ get(this.error_data, 'errors.fitrah[0]', false) }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='fitrah_beras'> Zakat Fitrah (Beras): </label>
                    <input
                        v-model='fitrah_beras'
                        class='form-control'
                        :class="{'is-invalid': get(this.error_data, 'errors.fitrah_beras[0]', false)}"
                        type='text'
                        id='fitrah_beras'
                        placeholder='Zakat Fitrah (Beras)'>
                    <div class='invalid-feedback'>
                         {{ get(this.error_data, 'errors.fitrah_beras[0]', false) }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='infak'> Infak: </label>
                    <input
                        v-model='infak'
                        class='form-control'
                        :class="{'is-invalid': get(this.error_data, 'errors.infak[0]', false)}"
                        type='text'
                        id='infak'
                        placeholder='Infak'>
                    <div class='invalid-feedback'>
                         {{ get(this.error_data, 'errors.infak[0]', false) }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='sedekah'> Sedekah: </label>
                    <input
                        v-model='sedekah'
                        class='form-control'
                        :class="{'is-invalid': get(this.error_data, 'errors.sedekah[0]', false)}"
                        type='text'
                        id='sedekah'
                        placeholder='Sedekah'>
                    <div class='invalid-feedback'>
                         {{ get(this.error_data, 'errors.sedekah[0]', false) }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="muzakki"> Muzaki: </label>
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
import { numberNormalize } from '../../../helpers'
import moment from 'moment'
import Multiselect from 'vue-multiselect'
import VueCleave from 'vue-cleave-component'
import numeral from 'numeral'

export default {
    components: { Multiselect, VueCleave },

    props: [
        "submit_url",
        "redirect_url",
        "muzakkis",
        "receivement",
    ],

    data() {
        return {
            transaction_date: moment(this.receivement.transaction_date).format("YYYY-MM-DD"),
            zakat: numberNormalize(this.receivement.zakat),
            fitrah: numberNormalize(this.receivement.fitrah),
            fitrah_beras: numberNormalize(this.receivement.fitrah_beras),
            infak: numberNormalize(this.receivement.fitrah_beras),
            sedekah: numberNormalize(this.receivement.sedekah),
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
                fitrah_beras: this.fitrah_beras,
                infak: this.infak,
                sedekah: this.sedekah,
                muzakki_id: get(this.muzakki, "id", null),
            }
        }
    },

    methods: {
        get,
        numberNormalize,

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
