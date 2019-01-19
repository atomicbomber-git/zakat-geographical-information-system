<template>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-map"></i>
                    Peta
                </div>
                <div class="card-body p-0">
                    <GmapMap
                        @click="onMapClick"
                        :center="center"
                        :zoom="14"
                        map-type-id="terrain"
                        style="width: 100%; height: 640px">

                        <GmapMarker
                            :position="{lat: donation.latitude,  lng: donation.longitude}"/>

                        <span v-for="collector in collectors" :key="collector.id">
                            <GmapMarker
                                @click="collector.infoWindowOpened=true"
                                icon="/png/mosque.png" 
                                :position="{lat: collector.latitude, lng: collector.longitude}"/>

                            <GmapInfoWindow
                                :position="{lat: collector.latitude, lng: collector.longitude}"
                                :opened="collector.infoWindowOpened"
                                @closeclick="collector.infoWindowOpened=false">
                                <div>
                                    <div class="card" style="width: 14rem">
                                        <img class="card-img-top" style="width: 14rem; height: 14rem; object-fit: cover" :src="collector.image_url" alt="Card image cap">
                                        <div class="card-body">
                                            <h5 class="card-title"> {{ collector.name }} </h5>
                                            <p class="card-text"> {{ collector.address }} </p>
                                        </div>
                                    </div>
                                </div>
                            </GmapInfoWindow>
                        </span>
                    </GmapMap>
                </div>
            </div>
        </div>
        <div class="col-5">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-pencil"></i>
                    Data Pemberian Zakat
                </div>
        
                <div class="card-body">
                    <form @submit="onFormSubmit">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="latitude"> Latitude: </label>
                                <input v-model.number="donation.latitude" step="any" type="number" class="form-control" id="latitude" placeholder="Latitude">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="longitude"> Longitude: </label>
                                <input v-model.number="donation.longitude" step="any" type="number" class="form-control" id="longitude" placeholder="Longitude">
                            </div>
                        </div>

                        <div class='form-group'>
                            <label for='transaction_date'> Tanggal Transaksi: </label>
                            <input
                                v-model='donation.transaction_date'
                                class='form-control'
                                :class="{'is-invalid': get(this.error_data, 'errors.transaction_date[0]', false)}"
                                type='date' id='transaction_date' placeholder='Tanggal Transaksi'>
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.transaction_date[0]', false) }}</div>
                        </div>

                        <div class='form-group'>
                            <label for='name'> Nama: </label>
                            <input
                                v-model='donation.name'
                                class='form-control'
                                :class="{'is-invalid': get(this.error_data, 'errors.name[0]', false)}"
                                type='text' id='name' placeholder='Nama'>
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.name[0]', false) }}</div>
                        </div>

                        <div class='form-group'>
                            <label for='gender'> Jenis Kelamin: </label>
                            <select class="form-control" v-model="donation.original_gender" name="gender" id="gender">
                                <option value="l"> Laki-Laki </option>
                                <option value="p"> Perempuan </option>
                            </select>

                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.gender[0]', false) }}</div>
                        </div>

                        <div class='form-group'>
                            <label for='NIK'> NIK: </label>
                            <input
                                v-model='donation.nik'
                                class='form-control'
                                :class="{'is-invalid': get(this.error_data, 'errors.NIK[0]', false)}"
                                type='text' id='NIK' placeholder='NIK'>
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.NIK[0]', false) }}</div>
                        </div>

                        <div class='form-group'>
                            <label for='address'> Alamat: </label>
                            <textarea
                                v-model='donation.address'
                                class='form-control'
                                :class="{'is-invalid': get(this.error_data, 'errors.address[0]', false)}"
                                type='text' id='address' placeholder='Alamat'></textarea>
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.address[0]', false) }}</div>
                        </div>

                        <div class='form-group'>
                            <label for='kecamatan'> Kecamatan: </label>
                            <input
                                v-model='donation.kecamatan'
                                class='form-control'
                                :class="{'is-invalid': get(this.error_data, 'errors.kecamatan[0]', false)}"
                                type='text' id='kecamatan' placeholder='Kecamatan'>
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.kecamatan[0]', false) }}</div>
                        </div>

                        <div class='form-group'>
                            <label for='kelurahan'> Kelurahan: </label>
                            <input
                                v-model='donation.kelurahan'
                                class='form-control'
                                :class="{'is-invalid': get(this.error_data, 'errors.kelurahan[0]', false)}"
                                type='text' id='kelurahan' placeholder='Kelurahan'>
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.kelurahan[0]', false) }}</div>
                        </div>

                        <div class='form-group'>
                            <label for='phone'> No. Telefon: </label>
                            <input
                                v-model='donation.phone'
                                class='form-control'
                                :class="{'is-invalid': get(this.error_data, 'errors.phone[0]', false)}"
                                type='phone' id='phone' placeholder='No. Telefon'>
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.phone[0]', false) }}</div>
                        </div>

                        <div class='form-group'>
                            <label for='occupation'> Pekerjaan: </label>
                            <input
                                v-model='donation.occupation'
                                class='form-control'
                                :class="{'is-invalid': get(this.error_data, 'errors.occupation[0]', false)}"
                                type='text' id='occupation' placeholder='Pekerjaan'>
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.occupation[0]', false) }}</div>
                        </div>

                        <div class='form-group'>
                            <label for='ansaf'> Ansaf: </label>
                            <input
                                v-model='donation.ansaf'
                                class='form-control'
                                :class="{'is-invalid': get(this.error_data, 'errors.ansaf[0]', false)}"
                                type='text' id='ansaf' placeholder='Ansaf'>
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.ansaf[0]', false) }}</div>
                        </div>

                        <div class='form-group'>
                            <label for='donation.help_program'> Program Bantuan: </label>
                            <input
                                v-model='donation.help_program'
                                class='form-control'
                                :class="{'is-invalid': get(this.error_data, 'errors.help_program[0]', false)}"
                                type='text' id='help_program' placeholder='Program Bantuan'>
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.help_program[0]', false) }}</div>
                        </div>

                        <div class='form-group'>
                            <label for='amount'> Nominal: </label>
                            <input
                                v-model.number='donation.amount'
                                class='form-control'
                                :class="{'is-invalid': get(this.error_data, 'errors.amount[0]', false)}"
                                step="1"
                                type='number' id='amount' placeholder='Nominal'>
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.amount[0]', false) }}</div>
                        </div>

                        <div class="form-group text-right">
                            <button class="btn btn-primary">
                                Perbarui Data
                                <i class="fa fa-check"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {get} from 'lodash'

export default {
    data() {
        return {
            center: {lat: window.donation.latitude, lng: window.donation.longitude},
            donation: window.donation,
            collectors: window.collectors.map(collector => {
                return {...collector, infoWindowOpened: false}
            }),
            error_data: null
        }
    },

    methods: {
        get: get,

        onMapClick(e) {
            this.donation.latitude = e.latLng.lat()
            this.donation.longitude = e.latLng.lng()
        },

        onFormSubmit(e) {
            e.preventDefault()

            let {original_gender, gender, ...form_data} = this.donation
            form_data = {gender: original_gender, ...form_data}

            axios.post(window.submit_route, form_data)
                .then(success => {
                    window.location.reload(true)
                })
                .catch(error => {
                    this.error_data = error.response.data
                })
        }
    },
}
</script>

<style>

</style>
