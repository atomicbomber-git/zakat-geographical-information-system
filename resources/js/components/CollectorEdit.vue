<template>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-map"></i>
                    Peta Lokasi Unit Pengumpulan Zakat
                </div>
                <div class="card-body">
                    <div id="app">
                        <GmapMap
                            :center="{lat: this.map.center_lat, lng: this.map.center_lng}"
                            :zoom="14"
                            @click="moveMarker"
                            map-type-id="terrain"
                            style="width: 100%; height: 640px">

                            <GmapMarker
                                v-if="pointer_marker"
                                :position="pointer_marker"
                                :clickable="true"
                            />

                            <GmapMarker
                                v-for="collector in collectors"
                                :key="collector.id"
                                :position="{lat: collector.latitude, lng: collector.longitude}"
                                :icon=this.icon_url
                            />

                        </GmapMap>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-5">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-pencil"></i>
                    Sunting Data Unit Pengumpulan Zakat
                </div>
                <div class="card-body">
                    <form @submit="submitForm">

                        <h3> Data Unit Pengumpulan Zakat </h3>
                        <hr>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="latitude"> Latitude: </label>
                                <input v-model="this.pointer_marker.lat" type="latitude" class="form-control" id="latitude" placeholder="Latitude" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="longitude"> Longitude: </label>
                                <input v-model="this.pointer_marker.lng" type="longitude" class="form-control" id="longitude" placeholder="Longitude" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="collector_name"> Nama Lokasi: </label>
                            <input
                                v-model="collector_name"
                                class="form-control"
                                :class="{'is-invalid': get(this.error_data, 'errors.collector_name[0]', false)}"
                                type="text" id="collector_name" placeholder="Nama lokasi">
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.collector_name[0]', false) }}</div>
                        </div>

                        <div class="form-group">
                            <label for="npwz"> NPWZ: </label>
                            <input
                                v-model="npwz"
                                class="form-control"
                                :class="{'is-invalid': get(this.error_data, 'errors.npwz[0]', false)}"
                                type="text" id="npwz" placeholder="Nama lokasi">
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.npwz[0]', false) }}</div>
                        </div>

                        <div class="form-group">
                            <label for="address"> Alamat Lokasi: </label>
                            <textarea
                                v-model="address"
                                class="form-control"
                                :class="{'is-invalid': get(this.error_data, 'errors.address[0]', false)}"
                                type="text" id="address" placeholder="Alamat lokasi"></textarea>
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.address[0]', false) }}</div>
                        </div>

                        <h3 class="mt-4"> Data Akun Administrator </h3>
                        <hr>

                        <div class="form-group">
                            <label for="user_name"> Nama Administrator: </label>
                            <input
                                v-model="user_name"
                                class="form-control"
                                :class="{'is-invalid': get(this.error_data, 'errors.user_name[0]', false)}"
                                type="text" id="user_name" placeholder="Nama Administrator">
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.user_name[0]', false) }}</div>
                        </div>

                        <div class="form-group">
                            <label for="username"> Username: </label>
                            <input
                                v-model="username"
                                class="form-control"
                                :class="{'is-invalid': get(this.error_data, 'errors.username[0]', false)}"
                                type="text" id="username" placeholder="Username">
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.username[0]', false) }}</div>
                        </div>

                        <div class="form-group">
                            <label for="password"> Password: </label>
                            <input
                                v-model="password"
                                class="form-control"
                                :class="{'is-invalid': get(this.error_data, 'errors.password[0]', false)}"
                                type="password" id="password" placeholder="Password">
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.password[0]', false) }}</div>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation"> Ulangi Password: </label>
                            <input
                                v-model="password_confirmation"
                                class="form-control"
                                :class="{'is-invalid': get(this.error_data, 'errors.password_confirmation[0]', false)}"
                                type="password" id="password_confirmation" placeholder="Ulangi Password">
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.password_confirmation[0]', false) }}</div>
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
    import axios from 'axios'
    import {get} from 'lodash'

    export default {
        mounted() {
        },
        
        data() {
            return {
                icon_url: window.icon_url,

                map: {
                    center_lat: window.collector.latitude,
                    center_lng: window.collector.longitude,
                },

                pointer_marker: {
                    lat: window.collector.latitude,
                    lng: window.collector.longitude,
                },

                collector_name: window.collector.name,
                npwz: window.collector.npwz,
                address: window.collector.npwz,

                user_name: window.collector.user.name,
                username: window.collector.user.username,
                password: "",
                password_confirmation: "",

                error_data: null,

                collectors: window.collectors
            }
        },

        computed: {
            form_data() {
                return {
                    latitude: this.pointer_marker.lat,
                    longitude: this.pointer_marker.lng,
                    collector_name: this.collector_name,
                    npwz: this.npwz,
                    address: this.address,
                    user_name: this.user_name,
                    username: this.username,
                    password: this.password,
                    password_confirmation: this.password_confirmation
                }
            }
        },

        methods: {
            get: get,

            moveMarker: function (e) {
                this.pointer_marker = {
                    lat: e.latLng.lat(),
                    lng: e.latLng.lng()
                }
            },

            submitForm: function (e) {
                e.preventDefault()
                
                axios.post(window.submit_url, this.form_data)
                    .then(response => {
                        window.location.replace(response.data.redirect)
                    })
                    .catch(error => {
                        this.error_data = error.response.data
                    })
            },

            deleteCollector: function(collector_id) {
                axios.post(`/collector/delete/${collector_id}`)
                    .then(response => { window.location.replace(response.data.redirect) })
                    .catch(error => { alert("Something wrong happened.") })
            }
        }
    }
</script>
