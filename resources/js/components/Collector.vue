<template>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-map"></i>
                    Peta Lokasi Unit Pengumpul Zakat
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

                            <span v-for="collector in collectors" :key="collector.id">

                                <GmapMarker
                                    :position="{lat: collector.latitude, lng: collector.longitude}"
                                    icon="/png/mosque.png"
                                    @click="onMarkerClick(collector)">
                                </GmapMarker>

                                <GmapInfoWindow
                                    :position="{lat: collector.latitude, lng: collector.longitude}"
                                    :opened="collector.isInfoWindowOpen"
                                    @closeclick="collector.isInfoWindowOpen=false">
                                    <div class="card">
                                        <img class="card-img-top" style="width: 14rem; height: 14rem; object-fit: cover" :src="collector.imageUrl" alt="Card image cap">
                                        <div class="card-body">
                                            <h5 class="card-title"> {{ collector.name }} </h5>
                                            <p class="card-text"> {{ collector.address }} </p>
                                        </div>
                                    </div>
                                </GmapInfoWindow>

                            </span>

                        </GmapMap>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-5">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-plus"></i>
                    Tambahkan Unit Pengumpul Zakat
                </div>
                <div class="card-body">
                    <form @submit="submitForm">

                        <h3> Data Unit Pengumpul Zakat </h3>
                        <hr>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="latitude"> Latitude: </label>
                                <input v-model.number="pointer_marker.lat" step="any" type="number" class="form-control" id="latitude" placeholder="Latitude">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="longitude"> Longitude: </label>
                                <input v-model.number="pointer_marker.lng" step="any" type="number" class="form-control" id="longitude" placeholder="Longitude">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="reg_number"> Nomor Registrasi: </label>
                            <input
                                v-model="reg_number"
                                class="form-control"
                                :class="{'is-invalid': get(this.error_data, 'errors.reg_number[0]', false)}"
                                type="text" id="reg_number" placeholder="Nama lokasi">
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.reg_number[0]', false) }}</div>
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
                            <label for="address"> Alamat Lokasi: </label>
                            <textarea
                                v-model="address"
                                class="form-control"
                                :class="{'is-invalid': get(this.error_data, 'errors.address[0]', false)}"
                                type="text" id="address" placeholder="Alamat lokasi"></textarea>
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.address[0]', false) }}</div>
                        </div>

                        <div class="form-group">
                            <label for="picture"> Foto UPZ: </label>
                            <div class="custom-file">
                                <input
                                    ref="picture"
                                    type="file"
                                    class="custom-file-input"
                                    id="picture"
                                    @change="changeFile"
                                    :class="{'is-invalid': get(this.error_data, 'errors.picture[0]', false)}">
                                <div class='invalid-feedback'>{{ get(this.error_data, 'errors.picture[0]', false) }}</div>
                                <label class="custom-file-label" for="picture"> {{ this.picture }} </label>
                            </div>
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
                            <label for="username"> Nama Pengguna: </label>
                            <input
                                v-model="username"
                                class="form-control"
                                :class="{'is-invalid': get(this.error_data, 'errors.username[0]', false)}"
                                type="text" id="username" placeholder="Nama Pengguna">
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.username[0]', false) }}</div>
                        </div>

                        <div class="form-group">
                            <label for="password"> Kata Sandi: </label>
                            <input
                                v-model="password"
                                class="form-control"
                                :class="{'is-invalid': get(this.error_data, 'errors.password[0]', false)}"
                                type="password" id="password" placeholder="Kata Sandi">
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.password[0]', false) }}</div>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation"> Ulangi Kata Sandi: </label>
                            <input
                                v-model="password_confirmation"
                                class="form-control"
                                :class="{'is-invalid': get(this.error_data, 'errors.password_confirmation[0]', false)}"
                                type="password" id="password_confirmation" placeholder="Ulangi Kata Sandi">
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.password_confirmation[0]', false) }}</div>
                        </div>

                        <div class="text-right">
                            <button class="btn btn-primary">
                                Tambahkan
                                <i class="fa fa-plus"></i>
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
        data() {
            return {
                icon_url: window.icon_url,

                pointer_marker: {
                    lat: -0.026330,
                    lng: 109.342504,
                },

                collector_name: "",
                reg_number: "",
                address: "",

                user_name: "",
                username: "",
                password: "",
                password_confirmation: "",
                picture: "",

                error_data: null,

                collectors: window.collectors.map(collector => {
                    return {
                        ...collector,
                        isInfoWindowOpen: false
                    }
                })
            }
        },

        computed: {
            form_data() {
                return {
                    latitude: this.pointer_marker.lat,
                    longitude: this.pointer_marker.lng,
                    collector_name: this.collector_name,
                    reg_number: this.reg_number,
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

            changeFile(event) {
                this.picture = event.target.value
            },

            onMarkerClick(collector) {
                this.collectors = this.collectors.map(c => {
                    if (c.id == collector.id) {
                        return {...c, isInfoWindowOpen: true}
                    }

                    return {...c, isInfoWindowOpen: false}
                })
            },

            submitForm: function (e) {
                e.preventDefault()

                let data = new FormData()

                let keys = Object.keys(this.form_data)
                for (let i = 0; i < keys.length; ++i) {
                    data.append(keys[i], this.form_data[keys[i]])
                }

                data.append('picture', this.$refs.picture.files[0])

                axios.post(window.submit_url, data, {
                        headers: { 'Content-Type': 'multipart/form-data' }
                    })
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
