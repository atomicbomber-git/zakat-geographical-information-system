<template>
    <div class="card">
        <div class="card-header">
            <i class="fa fa-map"></i>
            Peta Persebaran UPZ, Muzakki, dan Mustahiq
        </div>

        <div class="card-body">
            <div class="my-4">
                <div class="alert alert-primary">
                    <h2 class="h5">
                        Anda Sekarang berada di:
                        <strong>{{ this.pointer_address }}</strong>
                    </h2>

                    <hr/>

                    <h2 class="h5">
                        Saat ini, unit pengumpulan zakat terdekat adalah <strong> {{ get(this.nearest_collector, 'name', '-') }} </strong>
                        yang terletak di <span> {{ get(this.nearest_collector, 'address', '-') }} </span>
                        dan Anda dapat menyalurkan zakat disana.
                    </h2>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 pr-0" v-if="this.route_steps">
                    <h5>Petunjuk Jalan</h5>

                    <ol
                        class="list-group"
                        :style="{ 'max-height': '400px', 'overflow-y': 'scroll' }"
                    >
                        <li class="list-group-item" v-for="(step, i) in route_steps" :key="i">
                            <span v-html="step.instructions"></span>
                        </li>
                    </ol>
                </div>
                <div class="col-md">
                    <GmapMap
                        ref="mapRef"
                        @click="onMapClick"
                        :center="this.gmap_settings.center"
                        :zoom="this.gmap_settings.zoom"
                        :map-type-id="this.gmap_settings.map_type_id"
                        :style="this.gmap_settings.style"
                    >
                        <!-- Pointer Marker -->
                        <GmapMarker :position="pointer_marker"/>

                        <!-- Collector Markers and Info Windows -->
                        <template v-for="collector in p_collectors">
                            <GmapMarker
                                @click="onCollectorMarkerClick(collector)"
                                :icon="{
                                    url: icons.mosque_black,
                                    scaledSize: getCollectorIconScaledSize(collector)
                                }"
                                :position="{ lat: collector.latitude, lng: collector.longitude }"
                                :key="collector.id"
                            />

                            <!-- Mustahiq Markers -->
                            <template v-for="mustahiq in collector.mustahiqs">
                                <GmapMarker
                                    @click="onMustahiqMarkerClick(mustahiq)"
                                    :icon="icons.person_red"
                                    :position="{ lat: mustahiq.latitude, lng: mustahiq.longitude }"
                                    :key="`mustahiq_${mustahiq.id}`"
                                />
                            </template>

                            <!-- Muzakki Markers -->
                            <template v-for="muzakki in collector.muzakkis">
                                <GmapMarker
                                    @click="onMuzakkiMarkerClick(muzakki)"
                                    :icon="icons.person_green"
                                    :position="{ lat: muzakki.latitude, lng: muzakki.longitude }"
                                    :key="`muzakki_${muzakki.id}`"
                                />
                            </template>
                        </template>
                    </GmapMap>
                </div>

                <div class="col-md-3 pl-0" style="max-height: 640px; overflow-y: scroll">

                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-info"></i>
                            Legenda
                        </div>
                        <div class="card-body">
                            <div>
                                <img style="width: 30px; height:30px" :src="icons.mosque_black" alt="Mesjid">
                                Unit Pengumpulan Zakat
                            </div>
                            <div>
                                <img style="width: 30px; height:30px; padding: 5px" :src="icons.person_red" alt="Mesjid">
                                Mustahiq
                            </div>

                            <div v-if="can_see_muzakkis">
                                <img style="width: 30px; height:30px; padding: 5px" :src="icons.person_green" alt="Mesjid">
                                Muzakki
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-default w-100 mb-3"
                        @click="is_filter_visible =! is_filter_visible"
                        >
                        Filter
                        <i
                            class="fa"
                            :class="{
                                'fa-chevron-up': !is_filter_visible,
                                'fa-chevron-down': is_filter_visible
                                }">
                        </i>
                    </button>

                    <div v-if="is_filter_visible">
                        <!-- Muzakkis visibility toggle -->
                        <div v-if="this.can_see_muzakkis" class="list-group-item mb-3">
                            <div class="custom-control custom-checkbox">
                                <input
                                    v-model="is_muzakkis_visible"
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="checkbox_muzakki_visibility"
                                >
                                <label
                                    class="custom-control-label"
                                    for="checkbox_muzakki_visibility"
                                >Tampilkan Muzakki</label>
                            </div>
                        </div>

                        <div class="list-group">
                            <div
                                class="list-group-item"
                                v-for="(administrative_division, i) in administrative_divisions"
                                :key="i"
                                >
                                <kecamatan-toggle
                                    v-model="administrative_division.kecamatan"
                                    />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <modal name="collector-info" height="auto" width="800">
            <div class="card" v-if="selected_collector">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img
                                style="width: 100%; object-fit: cover"
                                :src="selected_collector.image_url"
                                :alt="selected_collector.name"
                            >
                        </div>
                        <div class="col-md-6">
                            <dl>
                                <dt>Nama Unit Pengumpulan Zakat:</dt>
                                <dd>{{ selected_collector.name }}</dd>

                                <dt>Alamat:</dt>
                                <dd>{{ selected_collector.address }}</dd>

                                <dt>Jumlah Mustahiq</dt>
                                <dd>{{ selected_collector.mustahiqs.length }}</dd>
                            </dl>

                            <hr>
                            <vue-frappe
                                v-if="selected_collector.donation_counts.length !== 0"
                                :id="`chart_${selected_collector.id}`"
                                :labels="selected_collector.donation_counts.map(record => record.year)"
                                title="Perkembangan Jumlah Penerimaan Zakat"
                                type="bar"
                                :dataSets="[{
                                    name: 'Penerimaan Zakat',
                                    values: selected_collector.donation_counts.map(record => record.count)
                                }]"
                                :tooltipOptions="{
                                    formatTooltipX: d => (d + '').toUpperCase(),
                                    formatTooltipY: d => d,
                                }"
                            ></vue-frappe>

                            <div v-else>
                                <i class="fa fa-warning"></i>
                                Data kosong.
                            </div>

                            <hr>

                            <p class="mb-2">
                                <strong>Mustahiq Terdekat:</strong>
                            </p>
                            <p>
                                {{ get(selected_collector.nearest_mustahiq, 'name', '-') }}
                                <br>
                                {{ get(selected_collector.nearest_mustahiq, 'address', '-') }}
                            </p>
                        </div>
                    </div>

                    <div class="text-right">
                        <button class="btn btn-sm btn-primary" @click="onDisplayRouteButtonClick">
                            Rute
                            <i class="fa fa-road"></i>
                        </button>
                    </div>
                </div>
            </div>
        </modal>

        <modal name="mustahiq-info" height="auto" width="800">
            <div class="card" v-if="selected_mustahiq">
                <div class="card-body">
                    <dl>
                        <dt>Nama:</dt>
                        <dd>{{ selected_mustahiq.name }}</dd>

                        <dt>Alamat:</dt>
                        <dd>{{ selected_mustahiq.address }}</dd>

                        <dt>Usia:</dt>
                        <dd>{{ selected_mustahiq.age }}</dd>

                        <dt>Pekerjaan:</dt>
                        <dd>{{ selected_mustahiq.occupation }}</dd>
                    </dl>
                </div>
            </div>
        </modal>

        <modal name="muzakki-info" height="auto" width="800">
            <div class="card" v-if="selected_muzakki">
                <div class="card-body">
                    <dl>
                        <dt>Nama:</dt>
                        <dd>{{ selected_muzakki.name }}</dd>
                    </dl>
                </div>
            </div>
        </modal>
    </div>
</template>

<script>

import { get } from 'lodash'
import icons from '../icons.js'
import { getDistance } from '../helpers.js'
import KecamatanToggle from './KecamatanToggle'

export default {
    props: [
        "collectors",
        "gmap_settings",
        "kecamatans",
        "can_see_muzakkis",
    ],

    components: { KecamatanToggle },

    mounted() {
        this.$refs.mapRef.$mapPromise.then(map => {
            this.map = map

            // Load Geocoder Service
            this.geocoder = new google.maps.Geocoder;

            // Load Directions Service and Display
            this.directionsService = new google.maps.DirectionsService()
            this.directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true, preserveViewport: true})
            this.directionsDisplay.setMap(map);

            this.loadAndSetCurrentAddress(this.pointer_marker.lat, this.pointer_marker.lng)
        })

        this.loadAndSetCurrentLocation()
    },

    data() {

        let default_center = this.gmap_settings.center

        return {
            icons,
            pointer_marker: default_center,
            pointer_address: null,

            administrative_divisions: Object.keys(this.kecamatans).map(kecamatan => ({
                kecamatan: {
                    name: kecamatan,
                    kelurahans: this.kecamatans[kecamatan].map(({ kelurahan }) => ({ name: kelurahan, is_visible: true })),
                    is_visible: true
                }
            })),

            nearest_collector: this.collectors.length === 0 ? null :
                this.collectors.reduce((acc, cur) => {
                    return getDistance(acc.latitude, acc.longitude, default_center.lat, default_center.lng) <=
                           getDistance(cur.latitude, cur.longitude, default_center.lat, default_center.lng) ? acc : cur
            }),

            is_filter_visible: false,
            route_steps: null,
            selected_collector: null,
            selected_mustahiq: null,
            selected_muzakki: null,
            is_muzakkis_visible: this.can_see_muzakkis,
        }
    },

    watch: {
        pointer_marker(pointer_marker) {
            // Determine the nearest collector
            this.nearest_collector = this.p_collectors.length === 0 ? null :
                this.p_collectors.reduce((acc, cur) => {
                return getDistance(acc.latitude, acc.longitude, pointer_marker.lat, pointer_marker.lng) <=
                       getDistance(cur.latitude, cur.longitude, pointer_marker.lat, pointer_marker.lng) ? acc : cur
            })

            // Reverse geocode current pointer's location to determine its real world address
            this.loadAndSetCurrentAddress(
                pointer_marker.lat,
                pointer_marker.lng
            )

            // Display route from the current pointer location to the selected collector
            if (this.selected_collector !== null) {
                this.loadAndDisplayRouteOnMap(this.pointer_marker, {
                    lat: this.selected_collector.latitude,
                    lng: this.selected_collector.longitude
                })
            }
        }
    },

    computed: {
        visible_kecamatan_names() {
            return this.administrative_divisions
                .filter(administrative_division => administrative_division.kecamatan.is_visible)
                .map(administrative_division => administrative_division.kecamatan.name)
        },

        visible_kelurahan_names() {

            let kelurahan_names = []

            this.administrative_divisions.forEach(({ kecamatan }) => {
                kecamatan.kelurahans.forEach(kelurahan => {
                    if (kelurahan.is_visible) {
                        kelurahan_names.push(kelurahan.name)
                    }
                })
            })

            return kelurahan_names
        },

        p_collectors() {
            return this.collectors
                .filter(({ kelurahan }) => this.visible_kelurahan_names.includes(kelurahan))
                .map(collector => {
                    let prepared_mustahiqs = collector.mustahiqs
                        .map(mustahiq => ({
                            ...mustahiq,
                            distance_from_collector: getDistance(mustahiq.latitude, mustahiq.longitude, collector.latitude, collector.longitude)
                        }))

                    return {
                        ...collector,
                        donation_counts: [],
                        muzakkis: collector.muzakkis !== undefined ? collector.muzakkis.filter(muzakki => this.is_muzakkis_visible) : [],
                        mustahiqs: prepared_mustahiqs,
                        nearest_mustahiq: prepared_mustahiqs.length === 0 ? null:
                            prepared_mustahiqs.reduce((acc, cur) =>
                                acc.distance_from_collector <= cur.distance_from_collector ? acc : cur
                            ),
                    }
            })
        }
    },

    methods: {
        get,

        getCollectorIconScaledSize(collector) {
            if (this.nearest_collector && (this.nearest_collector.id === collector.id)) {
                return { width: 80, height: 80, f: 'px', b: 'px' }
            }

            return {width: 40, height: 40, f: 'px', b: 'px'}
        },

        onMapClick(e) {
            this.pointer_marker = {
                lat: e.latLng.lat(),
                lng: e.latLng.lng(),
            }
        },

        onMustahiqMarkerClick(mustahiq) {
            this.selected_mustahiq = mustahiq
            this.$modal.show('mustahiq-info');
        },

        onMuzakkiMarkerClick(muzakki) {
            this.selected_muzakki = muzakki
            this.$modal.show('muzakki-info');
        },

        onCollectorMarkerClick(collector) {
            this.loadDonationCount(collector)
            this.selected_collector = collector
            this.$modal.show('collector-info');
        },

        onDisplayRouteButtonClick() {
            this.loadAndDisplayRouteOnMap(this.pointer_marker, {
                lat: this.selected_collector.latitude,
                lng: this.selected_collector.longitude
            })
            this.$modal.hide('collector-info');
        },

        loadAndSetCurrentLocation() {
            navigator.geolocation.getCurrentPosition(position => {
                this.pointer_marker = {
                    lat: position.coords.latitude,
                    lng:  position.coords.longitude,
                }
            },
            function (error) {
                console.log(error)
            },
            { enableHighAccuracy: true }
            )
        },

        loadAndSetCurrentAddress(latitude, longitude) {
            this.geocoder.geocode({location: {lat: latitude, lng: longitude}}, (results, status) => {
                if (status == "OK") {
                    this.pointer_address = results[0].formatted_address
                    return
                }

                console.error({results, status})
            })
        },

        loadAndDisplayRouteOnMap(origin, destination, travel_mode='DRIVING') {
            let direction_request = {
                origin: new google.maps.LatLng(origin),
                destination: new google.maps.LatLng(destination),
                travelMode: travel_mode,
            }

            this.directionsService.route(direction_request, (result, status) => {
                if (status == 'OK') {
                    this.directionsDisplay.setDirections(result)
                    this.route_steps = result.routes[0].legs[0].steps
                    return
                }

                console.error({ result, status })
            });
        },

        loadDonationCount(collector) {
            axios.get(`/donation/api/count/${collector.id}`)
                .then(response => {
                    collector.donation_counts = response.data
                })
                .catch(error => {
                    console.error(error)
                })
        }
    }
}
</script>
