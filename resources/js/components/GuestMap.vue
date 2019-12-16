<template>
    <div class="card">
        <div class="card-header">
            <i class="fa fa-map"></i>
            Peta Persebaran UPZ, Muzaki, dan Mustahik
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
                        Saat ini, unit pengumpul zakat terdekat adalah <strong> {{ get(this.nearest_collector_with_distance, 'name', '-') }} </strong>
                        yang terletak di <span> {{ get(this.nearest_collector_with_distance, 'address', '-') }} </span> dengan jarak
                        <strong> {{ this.nearest_collector_with_distance ? numberFormat(this.nearest_collector_with_distance.distance_from_pointer_marker) : "-" }} </strong> KM
                        dan Anda dapat menyalurkan zakat disana.
                    </h2>
                </div>
            </div>

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

            <div class="row">
                <div class="col-md-3 mb-2" v-if="this.route_steps">
                    <div class="d-flex justify-content-between mb-2">
                        <h5 class="mb-0">
                            Petunjuk Jalan
                        </h5>

                        <div class="text-right">
                            <button @click="selected_collector = null; route_steps = null; directionsDisplay.set('directions', null)" class="btn btn-default p-0">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <ol
                        class="list-group"
                        :style="{ 'max-height': '400px', 'overflow-y': 'scroll' }"
                    >
                        <li class="list-group-item" v-for="(step, i) in route_steps" :key="i">
                            <span v-html="step.instructions"></span>
                        </li>
                    </ol>
                </div>

                <div class="col-md mb-2">
                    <GmapMap
                        ref="mapRef"
                        @click="onMapClick"
                        :center="this.gmap_settings.center"
                        :zoom="this.gmap_settings.zoom"
                        :map-type-id="this.gmap_settings.map_type_id"
                        :style="this.gmap_settings.style"
                        >

                        <template v-if="services_loaded">
                            <!-- Pointer Marker -->
                            <GmapMarker :position="pointer_marker"/>

                            <!-- Collector Markers and Info Windows -->
                            <template v-for="collector in filtered_collectors_with_distance">
                                <GmapMarker
                                    @click="onCollectorMarkerClick(collector)"
                                    :icon="{
                                        url: icons.mosque_black,
                                        scaledSize: getCollectorIconScaledSize(collector)
                                    }"
                                    :position="{ lat: collector.latitude, lng: collector.longitude }"
                                    :key="collector.id"
                                />

                                <!-- Mustahik Markers -->
                                <template v-for="mustahiq in collector.mustahiqs">
                                    <GmapMarker
                                        @click="onMustahikMarkerClick(mustahiq)"
                                        :icon="icons.person_red"
                                        :position="{ lat: mustahiq.latitude, lng: mustahiq.longitude }"
                                        :key="`mustahiq_${mustahiq.id}`"
                                    />
                                </template>

                                <!-- Muzaki Markers -->
                                <template v-for="muzakki in collector.muzakkis">
                                    <GmapMarker
                                        @click="onMuzakiMarkerClick(muzakki)"
                                        :icon="icons.person_green"
                                        :position="{ lat: muzakki.latitude, lng: muzakki.longitude }"
                                        :key="`muzakki_${muzakki.id}`"
                                    />
                                </template>
                            </template>
                        </template>
                    </GmapMap>
                </div>

                <div
                    class="col-md-3 mb-2"
                    style="max-height: 640px; overflow-y: scroll"
                    >

                    <div class="form-group">
                        <label for="distance_filter">
                            Filter Jarak (dalam KM):
                        </label>
                        <input
                            class="form-control"
                            id="distance_filter"
                            placeholder="Filter jarak"
                            type="number"
                            step="any"
                            v-model="distance_filter"
                            >
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-info"></i>
                            Legenda
                        </div>
                        <div class="card-body">
                            <div>
                                <img style="width: 30px; height:30px" :src="icons.mosque_black" alt="Mesjid">
                                Unit Pengumpul Zakat
                            </div>
                            <div>
                                <img style="width: 30px; height:30px; padding: 5px" :src="icons.person_red" alt="Mesjid">
                                Mustahik
                            </div>

                            <div v-if="can_see_muzakkis">
                                <img style="width: 30px; height:30px; padding: 5px" :src="icons.person_green" alt="Mesjid">
                                Muzaki
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-light w-100 my-2"
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
                        <!-- Muzakis visibility toggle -->
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
                                >Tampilkan Muzaki</label>
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
                                <dt>Nama Unit Pengumpul Zakat:</dt>
                                <dd>{{ selected_collector.name }}</dd>

                                <dt>Alamat:</dt>
                                <dd>{{ selected_collector.address }}</dd>

                                <dt>Jumlah Mustahik</dt>
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
                                <strong>Mustahik Terdekat:</strong>
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
                    <h1 class="h5">
                        Identitas
                    </h1>

                    <dl>
                        <dt>Nama:</dt>
                        <dd>{{ selected_mustahiq.name }}</dd>

                        <dt>Alamat:</dt>
                        <dd>{{ selected_mustahiq.address }}</dd>

                        <dt>Usia:</dt>
                        <dd>{{ selected_mustahiq.age }}</dd>

                        <dt> Pekerjaan: </dt>
                        <dd> {{ selected_mustahiq.occupation }} </dd>
                    </dl>

                    <h1 class="h5 mt-5">
                        Penerimaan Zakat
                    </h1>

                    <table
                        v-if="selected_mustahiq.donations.length > 0"
                        class="table table-sm table-bordered table-striped">
                        <thead class="thead thead-dark">
                            <tr>
                                <th> Tanggal </th>
                                <th class="text-right"> Jumlah (Rp.) </th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr
                                :key="donation.id"
                                v-for="donation in selected_mustahiq.donations"
                                >

                                <td> {{ donation.transaction_date }} </td>
                                <td class="text-right"> {{ currencyFormat(donation.amount) }} </td>
                            </tr>
                        </tbody>
                    </table>
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

import { Multiselect } from "vue-multiselect"
import { get, debounce, chunk } from 'lodash'
import icons from '../icons.js'
import { getDistance, numberFormat } from '../helpers.js'
import KecamatanToggle from './KecamatanToggle'
import { Promise } from 'q';
import GmapDatalayerMixin from '../vue_mixins/GmapDatalayer'
import GmapDatalayer from '../vue_mixins/GmapDatalayer'
import { currencyFormat } from '../helpers'

export default {
    props: [
        "collector",
        "collectors",
        "gmap_settings",
        "kecamatans",
        "can_see_muzakkis",
        "datasource_url",
    ],

    components: { KecamatanToggle, Multiselect },

    mixins: [ GmapDatalayer ],

    mounted() {
        this.$refs.mapRef.$mapPromise.then(map => {
            this.map = map

            // Load Geocoder Service
            this.geocoder = new google.maps.Geocoder;

            // Load Directions Service and Display
            this.directionsService = new google.maps.DirectionsService()
            this.directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true, preserveViewport: true})
            this.directionsDisplay.setMap(map);

            // Load Places Service
            this.placesService = new google.maps.places.PlacesService(map);

            // Distance Matrix Service
            this.distanceMatrixService = new google.maps.DistanceMatrixService();

            this.services_loaded = true
            this.loadAndSetCurrentLocation()
            this.loadAndSetupDatalayer(this.datasource_url)
        })
    },

    data() {

        let default_center = this.gmap_settings.center

        return {
            services_loaded: false,
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

            is_filter_visible: false,
            route_steps: null,
            selected_collector: null,
            selected_mustahiq: null,
            selected_muzakki: null,
            is_muzakkis_visible: this.can_see_muzakkis,

            place: null,
            places: [],
            is_searching_place: false,
            distance_filter: null,
        }
    },

    watch: {
        pointer_marker(pointer_marker) {
            this.printDistanceFromCollectors()

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
        },

        place(place) {
            if (place === null) {
                return
            }

            this.setPointerMarkerAndMapCenter({
                lat: place.geometry.location.lat(),
                lng: place.geometry.location.lng(),
            })
        }
    },

    computed: {
        mustahiqs() {
            return this.p_collectors.reduce((curr, next) => {
                return [...curr, ...next.mustahiqs]
            }, [])
        },

        nearest_mustahiqs_with_distances() {
            return this.mustahiqs.map(mustahiq => {
                return {
                    ...mustahiq,
                    distance_from_pointer_marker: getDistance(
                        mustahiq.latitude, mustahiq.longitude,
                        this.pointer_marker.lat, this.pointer_marker.lng,
                    ),
                }
            })
            .filter(mustahiq => mustahiq.distance_from_pointer_marker <= 3.00)
            .sort((mustahiq_a, mustahiq_b) => {
                return mustahiq_a.distance_from_pointer_marker -
                    mustahiq_b.distance_from_pointer_marker
            })
        },

        nearest_collectors_with_distances() {
            return this.p_collectors.map(collector => {
                return {
                    ...collector,
                    distance_from_pointer_marker: getDistance(
                        collector.latitude, collector.longitude,
                        this.pointer_marker.lat, this.pointer_marker.lng,
                    )
                }
            })
            .sort((collector_a, collector_b) => {
                return collector_a.distance_from_pointer_marker -
                    collector_b.distance_from_pointer_marker
            })
        },

        filtered_collectors_with_distance() {
            return this.nearest_collectors_with_distances
                .filter(collector => {
                    if (this.distance_filter == null || this.distance_filter == "") {
                        return true
                    }
                    else {
                        return collector.distance_from_pointer_marker <= this.distance_filter
                    }
                })
        },

        nearest_collector_with_distance() {
            return this.nearest_collectors_with_distances.length > 0 ?
                this.nearest_collectors_with_distances[0] : null
        },

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
                .filter(collector => {
                    return this.collector ?
                        this.collector.id == collector.id : true
                })
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
        numberFormat,
        currencyFormat,

        getCollectorIconScaledSize(collector) {
            if (this.nearest_collector_with_distance && (this.nearest_collector_with_distance.id === collector.id)) {
                return { width: 80, height: 80, f: 'px', b: 'px' }
            }

            return {width: 40, height: 40, f: 'px', b: 'px'}
        },

        onPlaceSearchChange: debounce(function (search_query) {
            if (search_query == "") {
                return
            }

            let geocodingRequest = {
                address: search_query,
                componentRestrictions: {
                    country: 'Indonesia',
                    administrativeArea: 'Kota Pontianak',
                    locality: 'Kota Pontianak',
                },
            }

            this.is_searching_place = true
            this.geocoder.geocode(geocodingRequest, (results, status) => {
                if (status == 'OK') {
                    this.places = results
                }
                this.is_searching_place = false
            });
        }, 200),

        onMapClick(e) {
            this.pointer_marker = {
                lat: e.latLng.lat(),
                lng: e.latLng.lng(),
            }
        },

        setPointerMarkerAndMapCenter(location) {
            this.pointer_marker = {
                lat: location.lat,
                lng: location.lng,
            }

            this.map.setCenter({
                lat: location.lat,
                lng: location.lng,
            })
        },

        onMustahikMarkerClick(mustahiq) {
            this.selected_mustahiq = mustahiq
            this.$modal.show('mustahiq-info');
        },

        onMuzakiMarkerClick(muzakki) {
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
            }, null, { enableHighAccuracy: true })
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

        printDistanceFromCollectors() {
            console.clear()
            console.log(`Lokasi Anda sekarang adalah {lat: ${this.pointer_marker.lat}, lng: ${this.pointer_marker.lng}}`)

            console.table(
                this.nearest_collectors_with_distances
                    .map(collector => {
                        return {
                            nama: collector.name,
                            jarak_haversin: collector.distance_from_pointer_marker,
                        }
                    })
            )

            let origins = [{ lat: this.pointer_marker.lat, lng: this.pointer_marker.lng }]
            let destinations = this.nearest_collectors_with_distances
                .map(collector => ({ lat: collector.latitude, lng: collector.longitude }))

            let promises = []
            chunk(destinations, 25)
                .forEach(chunk => {
                    let distance_matrix_request = {
                        origins: origins,
                        destinations: chunk,
                        travelMode: 'DRIVING',
                    }

                    promises.push(new Promise((resolve, reject) => {
                        this.distanceMatrixService
                            .getDistanceMatrix(distance_matrix_request, (response, status) => {
                                if (status == "OK") {
                                    resolve(response)
                                }
                                else {
                                    reject(status)
                                }
                            })
                    }))
                })

            Promise.all(promises)
                .then(results => {
                    let distances = results.reduce((curr, next) => {
                        return [...curr, ...next.rows[0].elements]
                    }, [])
                    .map((element, i) => {
                        return {
                            nama: this.nearest_collectors_with_distances[i]
                                .name,
                            jarak_google_maps: element.distance.value / 1000
                        }
                    })

                    console.table(distances)
                })
                .catch(statuses => {
                    console.log(statuses)
                })
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
