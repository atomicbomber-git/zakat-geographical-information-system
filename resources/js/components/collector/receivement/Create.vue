<template>
    <div class="card">
        <div class="card-header">
            <i class="fa fa-plus"></i>
            Tambah Penerimaan Zakat
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

                <div class='form-group'>
                    <label for='zakat'> Zakat Mal: </label>
                    <input
                        v-model.number='zakat'
                        class='form-control'
                        :class="{'is-invalid': get(this.error_data, 'errors.zakat[0]', false)}"
                        type='number'
                        id='zakat'
                        placeholder='Zakat Mal'>
                    <div class='invalid-feedback'>
                         {{ get(this.error_data, 'errors.zakat[0]', false) }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='fitrah'> Zakat Fitrah (Tunai): </label>
                    <input
                        v-model.number='fitrah'
                        class='form-control'
                        :class="{'is-invalid': get(this.error_data, 'errors.fitrah[0]', false)}"
                        type='number'
                        id='fitrah'
                        placeholder='Zakat Fitrah (Tunai)'>
                    <div class='invalid-feedback'>
                         {{ get(this.error_data, 'errors.fitrah[0]', false) }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='fitrah_beras'> Zakat Fitrah (Beras): </label>
                    <input
                        v-model.number='fitrah_beras'
                        class='form-control'
                        :class="{'is-invalid': get(this.error_data, 'errors.fitrah_beras[0]', false)}"
                        type='number'
                        id='fitrah_beras'
                        placeholder='Zakat Fitrah (Beras)'>
                    <div class='invalid-feedback'>
                         {{ get(this.error_data, 'errors.fitrah_beras[0]', false) }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='infak'> Infak: </label>
                    <input
                        v-model.number='infak'
                        class='form-control'
                        :class="{'is-invalid': get(this.error_data, 'errors.infak[0]', false)}"
                        type='number'
                        id='infak'
                        placeholder='Infak'>
                    <div class='invalid-feedback'>
                         {{ get(this.error_data, 'errors.infak[0]', false) }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='sedekah'> Sedekah: </label>
                    <input
                        v-model.number='sedekah'
                        class='form-control'
                        :class="{'is-invalid': get(this.error_data, 'errors.sedekah[0]', false)}"
                        type='number'
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
                    <div class='text-danger' v-if="get(this.error_data, 'errors.muzakki_id[0]', false)">
                        {{ get(this.error_data, 'errors.muzakki_id[0]', false) }}
                    </div>
                </div>

                <div class="text-right">
                    <button class="btn btn-primary">
                        Tambah Penerimaan Zakat
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
        "submit_url",
        "redirect_url",
        "muzakkis",
    ],

    data() {
        return {
            transaction_date: null,
            zakat: null,
            fitrah: null,
            fitrah_beras: null,
            infak: null,
            sedekah: null,
            muzakki: null,
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
