<template>
    <div class="row">
        <div class="col-9">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-map"></i>
                    Peta Lokasi
                </div>
                <div class="card-body">
                    <div id="app">
                        <GmapMap
                            :center="{lat:-0.026330, lng:109.342504}"
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
                            />

                        </GmapMap>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <i class="fa fa-plus"></i>
                    Tambahkan Lokasi Baru
                </div>
                <div class="card-body">
                    <form @submit="submitForm">

                        <h3> Data Lokasi </h3>
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
                            <label for="name"> Nama Lokasi: </label>
                            <input
                                v-model="name"
                                class="form-control"
                                :class="{'is-invalid': get(this.error_data, 'errors.name[0]', false)}"
                                type="text" id="name" placeholder="Nama lokasi">
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.name[0]', false) }}</div>
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
                                type="password" id="password" placeholder="Nama lokasi">
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.password[0]', false) }}</div>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation"> Ulangi Password: </label>
                            <input
                                v-model="password_confirmation"
                                class="form-control"
                                :class="{'is-invalid': get(this.error_data, 'errors.password_confirmation[0]', false)}"
                                type="password" id="password_confirmation" placeholder="Nama lokasi">
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.password_confirmation[0]', false) }}</div>
                        </div>
                        
                        <div class="text-right">
                            <button class="btn btn-primary">
                                Tambahkan Lokasi
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-3">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-list"></i>
                    Daftar Lokasi
                </div>
                
                <!-- List of collectors -->
                <ul class="list-group list-group-flush">
                    <li v-for="collector in collectors" :key="collector.id" class="list-group-item">
                        <div>
                            <h3 class="text-capitalize font-weight-bold"> {{ collector.name }} </h3>
                            <p class="lead">
                                {{ collector.address }}
                            </p>
                        </div>

                        <div class="text-right">
                            <button @click="deleteCollector(collector.id)" class="btn btn-sm btn-danger">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import {get} from 'lodash'

    export default {
        mounted() {
            console.log(def_lat)
        },
        
        data() {
            return {
                pointer_marker: {
                    lat: def_lat,
                    lng: def_lng,
                },

                name: "",
                address: "",
                username: "",
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
                    name: this.name,
                    address: this.address,
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
