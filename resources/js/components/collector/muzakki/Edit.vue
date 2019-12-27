<template>
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-map"></i>
                    Peta
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <multiselect
                            placeholder="Pencarian Lokasi"
                            selectLabel=""
                            selectedLabel=""
                            deselectLabel=""
                            track-by="place_id"
                            label="formatted_address"
                            :options="places"
                            v-model="place"
                            :internal-search="false"
                            :loading="is_searching_place"
                            @search-change="onPlaceSearchChange"
                            >
                        </multiselect>
                    </div>

                    <GmapMap
                        ref="mapRef"
                        @click="onMapClick"
                        :center="{
                            lat: this.muzakki.latitude,
                            lng: this.muzakki.longitude,
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

                        <span v-for="muzakki in muzakkis" :key="muzakki.id">
                            <GmapMarker
                                icon="/png/person.png"
                                :position="{
                                    lat: muzakki.latitude,
                                    lng: muzakki.longitude
                                }"
                                @click="muzakki.infoWindowOpened=true"
                                />

                            <GmapInfoWindow
                                :position="{
                                    lat: muzakki.latitude,
                                    lng: muzakki.longitude
                                }"
                                :opened="muzakki.infoWindowOpened"
                                @closeclick="muzakki.infoWindowOpened=false"
                                >

                                <div>
                                    <p> {{ muzakki.name }} </p>
                                    <p> {{ muzakki.address }} </p>
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
                            <div class='form-group col-md-6'>
                                <label for='latitude'> Latitude: </label>
                                <input
                                    v-model.number='pointer_marker.lat'
                                    class='form-control'
                                    step="any"
                                    :class="{'is-invalid': get(this.error_data, 'errors.latitude[0]', false)}"
                                    type='number' id='latitude' placeholder='Latitude'>
                                <div class='invalid-feedback'>{{ get(this.error_data, 'errors.latitude[0]', false) }}</div>
                            </div>
                            <div class='form-group col-md-6'>
                                <label for='longitude'> Longitude: </label>
                                <input
                                    v-model='pointer_marker.lng'
                                    step="any"
                                    class='form-control'
                                    :class="{'is-invalid': get(this.error_data, 'errors.longitude[0]', false)}"
                                    type='number' id='longitude' placeholder='Longitude'>
                                <div class='invalid-feedback'>{{ get(this.error_data, 'errors.longitude[0]', false) }}</div>
                            </div>
                        </div>

                        <div class='form-group'>
                            <label for='name'> Nama: </label>
                            <input
                                v-model='name'
                                class='form-control'
                                :class="{'is-invalid': get(this.error_data, 'errors.name[0]', false)}"
                                type='text' id='name' placeholder='Nama'>
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.name[0]', false) }}</div>
                        </div>

                        <div class='form-group'>
                            <label for='occupation'> Pekerjaan: </label>
                            <input
                                v-model='occupation'
                                class='form-control'
                                :class="{'is-invalid': get(this.error_data, 'errors.occupation[0]', false)}"
                                type='text'
                                id='occupation'
                                placeholder='Pekerjaan'>
                            <div class='invalid-feedback'>
                                 {{ get(this.error_data, 'errors.occupation[0]', false) }}
                            </div>
                        </div>

                        <div class='form-group'>
                            <label for='gender'> Jenis Kelamin: </label>
                            <select class="form-control" v-model="gender" name="gender" id="gender">
                                <option value="l"> Laki-Laki </option>
                                <option value="p"> Perempuan </option>
                            </select>

                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.gender[0]', false) }}</div>
                        </div>

                        <div class='form-group'>
                            <label for='nik'> NIK: </label>
                            <input
                                v-model='nik'
                                class='form-control'
                                :class="{'is-invalid': get(this.error_data, 'errors.nik[0]', false)}"
                                type='text' id='nik' placeholder='NIK'>
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.nik[0]', false) }}</div>
                        </div>

                        <div class='form-group'>
                            <label for='address'> Alamat: </label>
                            <textarea
                                v-model='address'
                                class='form-control'
                                :class="{'is-invalid': get(this.error_data, 'errors.address[0]', false)}"
                                type='text' id='address' placeholder='Alamat'></textarea>
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.address[0]', false) }}</div>
                        </div>

                        <div class='form-group'>
                            <label for='kecamatan'> Kecamatan: </label>
                            <input
                                v-model='kecamatan'
                                class='form-control'
                                :class="{'is-invalid': get(this.error_data, 'errors.kecamatan[0]', false)}"
                                type='text' id='kecamatan' placeholder='Kecamatan'>
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.kecamatan[0]', false) }}</div>
                        </div>

                        <div class='form-group'>
                            <label for='kelurahan'> Kelurahan: </label>
                            <input
                                v-model='kelurahan'
                                class='form-control'
                                :class="{'is-invalid': get(this.error_data, 'errors.kelurahan[0]', false)}"
                                type='text' id='kelurahan' placeholder='Kelurahan'>
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.kelurahan[0]', false) }}</div>
                        </div>

                        <div class='form-group'>
                            <label for='phone'> Telepon: </label>
                            <input
                                v-model='phone'
                                class='form-control'
                                :class="{'is-invalid': get(this.error_data, 'errors.phone[0]', false)}"
                                type='text' id='phone' placeholder='Telepon'>
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.phone[0]', false) }}</div>
                        </div>

                        <div class='form-group'>
                            <label for='npwz'> NPWZ: </label>
                            <input
                                v-model='npwz'
                                class='form-control'
                                :class="{'is-invalid': get(this.error_data, 'errors.npwz[0]', false)}"
                                type='text' id='npwz' placeholder='NPWZ'>
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.npwz[0]', false) }}</div>
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
import GmapDatalayerMixin from '@/vue_mixins/GmapDatalayer'
import geotagInPontianak from "@/geotagInPontianak"

export default {
    props: [
        "gmap_settings",
        "collector",
        "submit_url",
        "redirect_url",
        "original_muzakkis",
        "muzakki",
        "datasource_url",
    ],

    mixins: [
        GmapDatalayerMixin
    ],

    mounted() {
        this.$refs.mapRef.$mapPromise.then(map => {
            this.map = map
            this.geocoder = new google.maps.Geocoder
            this.loadAndSetupDatalayer(this.datasource_url)
        })
    },

    data() {
        return {
            is_searching_place: false,
            place: null,
            places: [],

            muzakkis: this.original_muzakkis.map(muzakki => ({
                ...muzakki,
                infoWindowOpened: false
            })),

            error_data: null,

            pointer_marker: {
                lat: this.muzakki.latitude,
                lng: this.muzakki.longitude,
            },

            name: this.muzakki.name,
            gender: this.muzakki.gender,
            occupation: this.muzakki.occupation,
            nik: this.muzakki.NIK,
            address: this.muzakki.address,
            kecamatan: this.muzakki.kecamatan,
            kelurahan: this.muzakki.kelurahan,
            phone: this.muzakki.phone,
            npwz: this.muzakki.npwz,
            npwz: this.muzakki.occupation,
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
                npwz: this.npwz,
                occupation: this.occupation,
            }
        }
    },

    watch: {
        place() {
            if (this.place === null) {
                return
            }

            this.pointer_marker = {
                lat: this.place.geometry.location.lat(),
                lng: this.place.geometry.location.lng(),
            }
        }
    },

    methods: {
        get: get,

        onPlaceSearchChange: function (searchQuery) {
            geotagInPontianak({
                geocoder: this.geocoder,
                searchQuery: searchQuery,
                onBegin: () => { this.is_searching = true },
                onFinish: (results, status) => {
                    if (status == 'OK') {
                        this.places = results
                    }
                    this.is_searching_place = false
                }
            })
        },

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
                    let first_result = response.data.results[0]

                    this.address = get(first_result, "formatted_address", "-")

                    if (first_result.address_components !== null) {
                         let kelurahan_component = first_result.address_components.find(component => {
                            return component.types[0] === "administrative_area_level_4" &&
                                component.types[1] === "political"
                        })
                        this.kelurahan = get(kelurahan_component, "long_name", "-")

                        let kecamatan_component = first_result.address_components.find(component => {
                            return component.types[0] === "administrative_area_level_3" &&
                                component.types[1] === "political"
                        })
                        this.kecamatan = get(kecamatan_component, "long_name", "-")
                    }
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
