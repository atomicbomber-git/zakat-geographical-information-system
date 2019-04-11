<template>
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-map"></i>
                    Peta
                </div>
                <div class="card-body p-0">
                    <GmapMap
                        @click="onMapClick"
                        :center="{
                            lat: this.mustahiq.latitude,
                            lng: this.mustahiq.longitude
                        }"
                        :zoom="this.gmap_settings.zoom"
                        :map-type-id="this.gmap_settings.map_type_id"
                        :style="this.gmap_settings.style"
                    >
                        <GmapMarker
                            :position="{
                                lat: this.pointer_marker.lat,
                                lng: this.pointer_marker.lng
                            }"
                        />

                        <GmapMarker
                            @click="collector.infoWindowOpened=true"
                            icon="/png/mosque.png"
                            :position="{
                                lat: this.collector.latitude,
                                lng: this.collector.longitude
                            }"
                        />

                        <span v-for="mustahiq in mustahiqs" :key="mustahiq.id">
                            <GmapMarker
                                icon="/png/person.png"
                                :position="{
                                    lat: mustahiq.latitude,
                                    lng: mustahiq.longitude
                                }"
                                @click="mustahiq.infoWindowOpened=true"
                            />

                            <GmapInfoWindow
                                :position="{
                                    lat: mustahiq.latitude,
                                    lng: mustahiq.longitude
                                }"
                                :opened="mustahiq.infoWindowOpened"
                                @closeclick="mustahiq.infoWindowOpened=false"
                            >
                                <div>
                                    <p>{{ mustahiq.name }}</p>
                                    <p>{{ mustahiq.address }}</p>
                                </div>
                            </GmapInfoWindow>
                        </span>
                    </GmapMap>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-list"></i>
                    Data
                </div>

                <div class="card-body">
                    <form @submit.prevent="onFormSubmit">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="latitude">Latitude:</label>
                                <input
                                    v-model.number="pointer_marker.lat"
                                    class="form-control"
                                    step="any"
                                    :class="{'is-invalid': get(this.error_data, 'errors.latitude[0]', false)}"
                                    type="number"
                                    id="latitude"
                                    placeholder="Latitude"
                                >
                                <div
                                    class="invalid-feedback"
                                >{{ get(this.error_data, 'errors.latitude[0]', false) }}</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="longitude">Longitude:</label>
                                <input
                                    v-model="pointer_marker.lng"
                                    step="any"
                                    class="form-control"
                                    :class="{'is-invalid': get(this.error_data, 'errors.longitude[0]', false)}"
                                    type="number"
                                    id="longitude"
                                    placeholder="Longitude"
                                >
                                <div
                                    class="invalid-feedback"
                                >{{ get(this.error_data, 'errors.longitude[0]', false) }}</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name">Nama:</label>
                            <input
                                v-model="name"
                                class="form-control"
                                :class="{'is-invalid': get(this.error_data, 'errors.name[0]', false)}"
                                type="text"
                                id="name"
                                placeholder="Nama"
                            >
                            <div
                                class="invalid-feedback"
                            >{{ get(this.error_data, 'errors.name[0]', false) }}</div>
                        </div>

                        <div class="form-group">
                            <label for="gender">Jenis Kelamin:</label>
                            <select
                                class="form-control"
                                v-model="gender"
                                name="gender"
                                id="gender"
                            >
                                <option value="l">Laki-Laki</option>
                                <option value="p">Perempuan</option>
                            </select>

                            <div
                                class="invalid-feedback"
                            >{{ get(this.error_data, 'errors.gender[0]', false) }}</div>
                        </div>

                        <div class="form-group">
                            <label for="nik">NIK:</label>
                            <input
                                v-model="nik"
                                class="form-control"
                                :class="{'is-invalid': get(this.error_data, 'errors.nik[0]', false)}"
                                type="text"
                                id="nik"
                                placeholder="NIK"
                            >
                            <div
                                class="invalid-feedback"
                            >{{ get(this.error_data, 'errors.nik[0]', false) }}</div>
                        </div>

                        <div class="form-group">
                            <label for="address">Alamat:</label>
                            <textarea
                                v-model="address"
                                class="form-control"
                                :class="{'is-invalid': get(this.error_data, 'errors.address[0]', false)}"
                                type="text"
                                id="address"
                                placeholder="Alamat"
                            ></textarea>
                            <div
                                class="invalid-feedback"
                            >{{ get(this.error_data, 'errors.address[0]', false) }}</div>
                        </div>

                        <div class="form-group">
                            <label for="kecamatan">Kecamatan:</label>
                            <input
                                v-model="kecamatan"
                                class="form-control"
                                :class="{'is-invalid': get(this.error_data, 'errors.kecamatan[0]', false)}"
                                type="text"
                                id="kecamatan"
                                placeholder="Kecamatan"
                            >
                            <div
                                class="invalid-feedback"
                            >{{ get(this.error_data, 'errors.kecamatan[0]', false) }}</div>
                        </div>

                        <div class="form-group">
                            <label for="kelurahan">Kelurahan:</label>
                            <input
                                v-model="kelurahan"
                                class="form-control"
                                :class="{'is-invalid': get(this.error_data, 'errors.kelurahan[0]', false)}"
                                type="text"
                                id="kelurahan"
                                placeholder="Kelurahan"
                            >
                            <div
                                class="invalid-feedback"
                            >{{ get(this.error_data, 'errors.kelurahan[0]', false) }}</div>
                        </div>

                        <div class="form-group">
                            <label for="phone">Telepon:</label>
                            <input
                                v-model="phone"
                                class="form-control"
                                :class="{'is-invalid': get(this.error_data, 'errors.phone[0]', false)}"
                                type="text"
                                id="phone"
                                placeholder="Telepon"
                            >
                            <div
                                class="invalid-feedback"
                            >{{ get(this.error_data, 'errors.phone[0]', false) }}</div>
                        </div>

                        <div class="form-group">
                            <label for="occupation">Pekerjaan:</label>
                            <input
                                v-model="occupation"
                                class="form-control"
                                :class="{'is-invalid': get(this.error_data, 'errors.occupation[0]', false)}"
                                type="text"
                                id="occupation"
                                placeholder="Pekerjaan"
                            >
                            <div
                                class="invalid-feedback"
                            >{{ get(this.error_data, 'errors.occupation[0]', false) }}</div>
                        </div>

                        <div class="form-group">
                            <label for="asnaf"> Asnaf: </label>
                            <input
                                v-model="asnaf"
                                class="form-control"
                                :class="{'is-invalid': get(this.error_data, 'errors.asnaf[0]', false)}"
                                type="text"
                                id="asnaf"
                                placeholder="asnaf"
                            >
                            <div
                                class="invalid-feedback"
                            >{{ get(this.error_data, 'errors.asnaf[0]', false) }}</div>
                        </div>

                        <div class="form-group">
                            <label for="help_program">Program Bantuan:</label>
                            <input
                                v-model="help_program"
                                class="form-control"
                                :class="{'is-invalid': get(this.error_data, 'errors.help_program[0]', false)}"
                                type="text"
                                id="help_program"
                                placeholder="Program Bantuan"
                            >
                            <div
                                class="invalid-feedback"
                            >{{ get(this.error_data, 'errors.help_program[0]', false) }}</div>
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
        </div>
    </div>
</template>

<script>

import { get } from 'lodash'
import axios from 'axios'

export default {
    props: [
        "gmap_settings", "collector",
        "submit_url", "redirect_url",
        "original_mustahiqs", "mustahiq"

    ],

    data() {
        return {
            mustahiqs: this.original_mustahiqs.map(mustahiq => ({
                ...mustahiq,
                infoWindowOpened: false
            })),

            error_data: null,

            pointer_marker: {
                lat: this.mustahiq.latitude,
                lng: this.mustahiq.longitude,
            },

            name: this.mustahiq.name,
            gender: this.mustahiq.gender,
            nik: this.mustahiq.nik,
            address: this.mustahiq.address,
            kecamatan: this.mustahiq.kecamatan,
            kelurahan: this.mustahiq.kelurahan,
            phone: this.mustahiq.phone,
            occupation: this.mustahiq.occupation,
            asnaf: this.mustahiq.asnaf,
            help_program: this.mustahiq.help_program,
        }
    },

    computed: {
        form_data() {
            return {
                latitude: this.pointer_marker.lat,
                longitude: this.pointer_marker.lng,
                name: this.name,
                gender: this.gender,
                nik: this.nik,
                address: this.address,
                kecamatan: this.kecamatan,
                kelurahan: this.kelurahan,
                phone: this.phone,
                occupation: this.occupation,
                asnaf: this.asnaf,
                help_program: this.help_program,
            }
        }
    },

    methods: {
        get: get,

        onMapClick(e) {
            this.pointer_marker = {
                lat: e.latLng.lat(),
                lng: e.latLng.lng()
            }
            this.autofillAdresses()
        },

        autofillAdresses() {
            axios.get(`https://maps.googleapis.com/maps/api/geocode/json?latlng=${this.pointer_marker.lat},${this.pointer_marker.lng}&key=AIzaSyBDzI0csQYqh24xwIyl_-rlKynmiam4DGU&language=id`)
                .then(response => {
                    let address = response.data.results[0].formatted_address.split(', ')
                    this.address = address[0]
                    this.kecamatan = address[1]
                    this.kelurahan = address[2]
                })
                .catch(error => {
                    console.error(error)
                })
        },

        onFormSubmit() {
            axios.post(this.submit_url, this.form_data)
               .then(response => {
                    window.location.replace(this.redirect_url)
               })
               .catch(error => {
                   this.error_data = error.response.data
               })
        }
    }
}
</script>