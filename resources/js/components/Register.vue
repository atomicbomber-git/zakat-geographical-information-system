<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form @submit.prevent="onFormSubmit">
                        <h3> Data Unit Pengumpulan Zakat </h3>
                        <hr>

                        <div class="form-group">
                            <label for="collector_name"> Nama UPZ: </label>
                            <input
                                v-model="collector_name"
                                class="form-control"
                                :class="{'is-invalid': get(this.error_data, 'errors.collector_name[0]', false)}"
                                type="text" id="collector_name" placeholder="Nama UPZ">
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.collector_name[0]', false) }}</div>
                        </div>

                        <div class="form-group">
                            <label for="address"> Alamat: </label>
                            <textarea
                                v-model="address"
                                class="form-control"
                                :class="{'is-invalid': get(this.error_data, 'errors.address[0]', false)}"
                                type="text" id="address" placeholder="Alamat UPZ"></textarea>
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
                            <label for='phone'> Nomor Telefon: </label>
                            <input
                                v-model='phone'
                                class='form-control'
                                :class="{'is-invalid': get(this.error_data, 'errors.phone[0]', false)}"
                                type='phone'
                                id='phone'
                                placeholder='Nomor Telefon'>
                            <div class='invalid-feedback'>
                                 {{ get(this.error_data, 'errors.phone[0]', false) }}
                            </div>
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

                        <div class='form-group'>
                            <label for='penasehat'> Penasehat: </label>
                            <input
                                v-model='penasehat'
                                class='form-control'
                                :class="{'is-invalid': get(this.error_data, 'errors.penasehat[0]', false)}"
                                type='text'
                                id='penasehat'
                                placeholder='Penasehat'>
                            <div class='invalid-feedback'>
                                 {{ get(this.error_data, 'errors.penasehat[0]', false) }}
                            </div>
                        </div>

                        <div class='form-group'>
                            <label for='ketua'> Ketua: </label>
                            <input
                                v-model='ketua'
                                class='form-control'
                                :class="{'is-invalid': get(this.error_data, 'errors.ketua[0]', false)}"
                                type='text'
                                id='ketua'
                                placeholder='Ketua'>
                            <div class='invalid-feedback'>
                                 {{ get(this.error_data, 'errors.ketua[0]', false) }}
                            </div>
                        </div>

                        <div class='form-group'>
                            <label for='sekretaris'> Sekretaris: </label>
                            <input
                                v-model='sekretaris'
                                class='form-control'
                                :class="{'is-invalid': get(this.error_data, 'errors.sekretaris[0]', false)}"
                                type='text'
                                id='sekretaris'
                                placeholder='Sekretaris'>
                            <div class='invalid-feedback'>
                                 {{ get(this.error_data, 'errors.sekretaris[0]', false) }}
                            </div>
                        </div>

                        <div class='form-group'>
                            <label for='bendahara'> Bendahara: </label>
                            <input
                                v-model='bendahara'
                                class='form-control'
                                :class="{'is-invalid': get(this.error_data, 'errors.bendahara[0]', false)}"
                                type='text'
                                id='bendahara'
                                placeholder='Bendahara'>
                            <div class='invalid-feedback'>
                                 {{ get(this.error_data, 'errors.bendahara[0]', false) }}
                            </div>
                        </div>

                        <div class='form-group'>
                            <label for='anggota_1'> Anggota: </label>
                            <input
                                v-model='anggota_1'
                                class='form-control'
                                :class="{'is-invalid': get(this.error_data, 'errors.anggota_1[0]', false)}"
                                type='text'
                                id='anggota_1'
                                placeholder='Anggota'>
                            <div class='invalid-feedback'>
                                 {{ get(this.error_data, 'errors.anggota_1[0]', false) }}
                            </div>
                        </div>

                        <div class='form-group'>
                            <label for='anggota_2'> Anggota: </label>
                            <input
                                v-model='anggota_2'
                                class='form-control'
                                :class="{'is-invalid': get(this.error_data, 'errors.anggota_2[0]', false)}"
                                type='text'
                                id='anggota_2'
                                placeholder='Anggota'>
                            <div class='invalid-feedback'>
                                 {{ get(this.error_data, 'errors.anggota_2[0]', false) }}
                            </div>
                        </div>

                        <h3 class="mt-4"> Data Akun Administrator </h3>
                        <hr>

                        <div class="form-group">
                            <label for="admin_name"> Nama Administrator: </label>
                            <input
                                v-model="admin_name"
                                class="form-control"
                                :class="{'is-invalid': get(this.error_data, 'errors.admin_name[0]', false)}"
                                type="text" id="admin_name" placeholder="Nama Administrator">
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.admin_name[0]', false) }}</div>
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
                                Registrasi
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
    import { get } from 'lodash'

    export default {
        props: [
            "submit_url",
            "redirect_url",
            "collectors",
            "config",
        ],

        mounted() {
            this.$refs.mapRef.$mapPromise.then(map => {
                this.geocoder = new google.maps.Geocoder;
            })
        },

        data() {
            return {
                icon_url: window.icon_url,
                collector_name: "",
                address: "",
                kelurahan: "",
                kecamatan: "",
                phone: "",

                penasehat: "",
                ketua: "",
                sekretaris: "",
                bendahara: "",
                anggota_1: "",
                anggota_2: "",

                admin_name: "",
                username: "",
                password: "",
                password_confirmation: "",
                picture: "",
                error_data: null,
                m_collectors: this.collectors
                    .map(collector => ({
                        ...collector,
                        isInfoWindowOpen: false,
                    }))
            }
        },

        computed: {
            form_data() {
                return {
                    collector_name: this.collector_name,
                    address: this.address,
                    kecamatan: this.kecamatan,
                    kelurahan: this.kelurahan,
                    phone: this.phone,
                    penasehat: this.penasehat,
                    ketua: this.ketua,
                    sekretaris: this.sekretaris,
                    bendahara: this.bendahara,
                    anggota_1: this.anggota_1,
                    anggota_2: this.anggota_2,
                    admin_name: this.admin_name,
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
                    lng: e.latLng.lng(),
                }
            },

            changeFile(event) {
                this.picture = event.target.value
            },

            onMarkerClick(collector) {
                this.m_collectors = this.m_collectors.map(c => {
                    if (c.id == collector.id) {
                        return {...c, isInfoWindowOpen: true}
                    }

                    return {...c, isInfoWindowOpen: false}
                })
            },

            onFormSubmit() {
                let data = new FormData()

                let keys = Object.keys(this.form_data)
                for (let i = 0; i < keys.length; ++i) {
                    data.append(keys[i], this.form_data[keys[i]])
                }

                data.append('picture', this.$refs.picture.files[0])

                axios.post(this.submit_url, data, {
                        headers: { 'Content-Type': 'multipart/form-data' }
                    })
                    .then(response => {
                        window.location.replace(this.redirect_url)
                    })
                    .catch(error => {
                        this.error_data = error.response.data
                    })
            },
        },

        watch: {
            pointer_marker() {
                this.geocoder.geocode({location: this.pointer_marker}, (results, status) => {
                    if (status == "OK") {
                        let first_result = results[0]

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
                        return
                    }

                    console.error({results, status})
                })
            }
        }
    }
</script>
