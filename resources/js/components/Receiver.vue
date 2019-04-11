<template>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-map"></i>
                    Peta Lokasi Penerima Zakat
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

                            <span v-for="receiver in receivers" :key="receiver.id">

                                <GmapMarker
                                    :position="{lat: receiver.latitude, lng: receiver.longitude}"
                                    @click="onMarkerClick(receiver)"
                                    icon="/png/person.png">
                                </GmapMarker>

                                <GmapInfoWindow
                                    :position="{lat: receiver.latitude, lng: receiver.longitude}"
                                    :opened="receiver.isInfoWindowOpen"
                                    @closeclick="receiver.isInfoWindowOpen=false">
                                    <div>
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title"> {{ receiver.name }} </h5>
                                                <hr>

                                                <div class="row">
                                                    <div class="col">
                                                        <dl>
                                                            <dt> NIK: </dt> <dd> {{ receiver.nik }} </dd>
                                                            <dt> Alamat: </dt> <dd> {{ receiver.address }} </dd>
                                                            <dt> Kecamatan: </dt> <dd> {{ receiver.kecamatan }} </dd>
                                                            <dt> Kelurahan: </dt> <dd> {{ receiver.kelurahan }} </dd>
                                                            <dt> No. Telp: </dt> <dd> {{ receiver.phone }} </dd>
                                                        </dl>
                                                    </div>
                                                    <div class="col">
                                                        <dl>
                                                            <dt> Jenis Kelamin: </dt> <dd> {{ receiver.sex }} </dd>
                                                            <dt> Pendidikan: </dt> <dd> {{ receiver.education }} </dd>
                                                            <dt> asnaf: </dt> <dd> {{ receiver.asnaf }} </dd>
                                                            <dt> Program Bantuan: </dt> <dd> {{ receiver.help_program }} </dd>
                                                            <dt> Jumlah: </dt> <dd> Rp. {{ parseFloat(receiver.amount).toLocaleString('id-ID') }} </dd>
                                                        </dl>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </GmapInfoWindow>

                            </span>

                            <span v-for="collector in collectors" :key="'R' + collector.id">
                                <GmapMarker
                                    :position="{lat: collector.latitude, lng: collector.longitude}"
                                    @click="onCollectorMarkerClick(collector)"
                                    icon="/png/mosque.png">
                                </GmapMarker>

                                <GmapInfoWindow
                                    :position="{lat: collector.latitude, lng: collector.longitude}"
                                    :opened="collector.isInfoWindowOpen"
                                    @closeclick="collector.isInfoWindowOpen=false">
                                    <div>
                                        <div class="card">
                                            <img class="card-img-top" style="width: 14rem; height: 14rem; object-fit: cover" :src="collector.imageUrl" alt="Card image cap">
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
        </div>

        <div class="col-5">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-plus"></i>
                    Tambahkan Penerima Zakat
                </div>
                <div class="card-body">
                    <form @submit="submitForm">

                        <h3> Data Penerima Zakat </h3>
                        <hr>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="latitude"> Latitude: </label>
                                <input v-model.number="this.pointer_marker.lat" type="number" step="any" class="form-control" id="latitude" placeholder="Latitude">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="longitude"> Longitude: </label>
                                <input v-model.number="this.pointer_marker.lng" type="number" step="any" class="form-control" id="longitude" placeholder="Longitude">
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
                            <label for='phone'> No. HP: </label>
                            <input
                                v-model='phone'
                                class='form-control'
                                :class="{'is-invalid': get(this.error_data, 'errors.phone[0]', false)}"
                                type='text' id='phone' placeholder='No. HP'>
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.phone[0]', false) }}</div>
                        </div>

                        <div class='form-group'>
                            <label for='sex'> Jenis Kelamin: </label>
                            <input
                                v-model='sex'
                                class='form-control'
                                :class="{'is-invalid': get(this.error_data, 'errors.sex[0]', false)}"
                                type='text' id='sex' placeholder='Jenis Kelamin'>
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.sex[0]', false) }}</div>
                        </div>

                        <div class='form-group'>
                            <label for='occupation'> Pekerjaan: </label>
                            <input
                                v-model='occupation'
                                class='form-control'
                                :class="{'is-invalid': get(this.error_data, 'errors.occupation[0]', false)}"
                                type='text' id='occupation' placeholder='Pekerjaan'>
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.occupation[0]', false) }}</div>
                        </div>
                        <div class='form-group'>
                            <label for='asnaf'> asnaf: </label>
                            <input
                                v-model='asnaf'
                                class='form-control'
                                :class="{'is-invalid': get(this.error_data, 'errors.asnaf[0]', false)}"
                                type='text' id='asnaf' placeholder='asnaf'>
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.asnaf[0]', false) }}</div>
                        </div>

                        <div class='form-group'>
                            <label for='help_program'> Program Bantuan: </label>
                            <input
                                v-model='help_program'
                                class='form-control'
                                :class="{'is-invalid': get(this.error_data, 'errors.help_program[0]', false)}"
                                type='text' id='help_program' placeholder='Program Bantuan'>
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.help_program[0]', false) }}</div>
                        </div>

                        <div class='form-group'>
                            <label for='amount'> Jumlah Zakat: </label>
                            <input
                                v-model='amount'
                                class='form-control'
                                :class="{'is-invalid': get(this.error_data, 'errors.amount[0]', false)}"
                                type='number' id='amount' placeholder='Jumlah Zakat'>
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.amount[0]', false) }}</div>
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
                    lng: 109.342504
                },

                name: "",
                nik: "",
                address: "",
                kecamatan: "",
                kelurahan: "",
                phone: "",
                sex: "",
                occupation: "",
                asnaf: "",
                help_program: "",
                amount: null,

                error_data: null,

                receivers: window.receivers.map(receiver => { return {...receiver, isInfoWindowOpen: false} }),
                collectors: window.collectors.map(collector => { return {...collector, isInfoWindowOpen: false} })
            }
        },

        computed: {
            form_data() {
                return {
                    latitude: this.pointer_marker.lat,
                    longitude: this.pointer_marker.lng,
                    name: this.name,
                    nik: this.nik,
                    address: this.address,
                    kecamatan: this.kecamatan,
                    kelurahan: this.kelurahan,
                    phone: this.phone,
                    sex: this.sex,
                    occupation: this.occupation,
                    asnaf: this.asnaf,
                    help_program: this.help_program,
                    amount: this.amount
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

            onMarkerClick(receiver) {
                receiver.isInfoWindowOpen = true
            },

            onCollectorMarkerClick(collector) {
                console.log(collector)
                collector.isInfoWindowOpen = true
            },

            submitForm: function (e) {
                e.preventDefault()

                axios.post(`/receiver/store`, this.form_data)
                    .then(response => {
                        alert("success")
                    })
                    .catch(error => {
                        this.error_data = error.response.data
                    })
            }
        }
    }
</script>
