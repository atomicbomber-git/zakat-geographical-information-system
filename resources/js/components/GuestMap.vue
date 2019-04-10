<template>
    <div class="card">
        <div class="card-header">
            <i class="fa fa-map"></i>
            Peta Persebaran UPZ, Muzakki, dan Mustahiq
        </div>

        <div class="card-body p-0">

            <div class="my-4 mx-4">

                <p>
                    Anda sekarang berada di
                    <strong>
                        {{ this.pointer_address }}
                    </strong>
                </p>

                <div class="alert alert-info">
                    <h2 class="h3">
                        <i class="fa fa-info"></i>
                        Unit Pengumpulan Zakat Terdekat:
                    </h2>
                    {{ this.nearest_collector.name }} <br/>
                    {{ this.nearest_collector.address }}
                </div>
            </div>

            <GmapMap
                ref="mapRef"
                @click="onMapClick"
                :center="this.gmap_settings.center"
                :zoom="this.gmap_settings.zoom"
                :map-type-id="this.gmap_settings.map_type_id"
                :style="this.gmap_settings.style"
                >

                <!-- Pointer Marker -->
                <GmapMarker
                    :position="pointer_marker"
                    />

                <!-- Collector Markers and Info Windows -->
                <template v-for="collector in p_collectors">
                    <GmapMarker
                        @click="onCollectorMarkerClick(collector)"
                        :icon="icons.mosque_black"
                        :position="{ lat: collector.latitude, lng: collector.longitude }"
                        :key="collector.id"
                        />

                    <GmapInfoWindow
                        :position="{lat: collector.latitude, lng: collector.longitude}"
                        :opened="collector.info_window_opened"
                        @closeclick="collector.info_window_opened=false"
                        :key="`collector_info_${collector.id}`"
                        >

                        <div class="card" style="width: 25rem;">
                            <img class="card-img-top" style="width: auto; height: auto; object-fit: cover" :src="collector.image_url" alt="Gambar UPZ">
                            <div class="card-body">
                                <h5 class="card-title">
                                    {{ collector.name }}
                                </h5>
                                <p class="card-text">
                                    {{ collector.address }}
                                </p>
                                
                                <hr>
                                <vue-frappe
                                    v-if="collector.donation_counts.length !== 0"
                                    :id="`chart_${collector.id}`"
                                    :labels="collector.donation_counts.map(record => record.year)"
                                    title="Perkembangan Jumlah Penerimaan Zakat"
                                    type="bar"
                                    :dataSets="[{
                                        name: 'Penerimaan Zakat',
                                        values: collector.donation_counts.map(record => record.count)
                                    }]"
                                    :tooltipOptions="{
                                        formatTooltipX: d => (d + '').toUpperCase(),
                                        formatTooltipY: d => d,
                                    }"
                                    >
                                </vue-frappe>

                                <hr>

                                <p class="mb-2"> <strong> Mustahiq Terdekat: </strong> </p>
                                <p>
                                    {{ collector.nearest_mustahiq.name }} <br/>
                                    {{ collector.nearest_mustahiq.address }}
                                </p>
                            </div>
                        </div>
                    </GmapInfoWindow>

                    <!-- Muzakki Markers and Info Windows -->
                    <!-- <template v-for="muzakki in collector.muzakkis">
                        <GmapMarker
                            @click="onMuzakkiMarkerClick(muzakki)"
                            :icon="icons.person_red"
                            :position="{ lat: muzakki.latitude, lng: muzakki.longitude }"
                            :key="`muzakki_marker_${muzakki.id}`"
                            />

                        <GmapInfoWindow
                            :position="{lat: muzakki.latitude, lng: muzakki.longitude}"
                            :opened="muzakki.info_window_opened"
                            @closeclick="muzakki.info_window_opened=false"
                            :key="`muzakki_info_${muzakki.id}`"
                            >
                            <div>
                                <h4> Muzakki </h4>
                                <p>{{ muzakki.name }}</p>
                                <p>{{ muzakki.address }}</p>
                            </div>
                        </GmapInfoWindow>
                    </template> -->

                    <!-- Mustahiq Markers -->
                    <template v-for="mustahiq in collector.mustahiqs">
                        <GmapMarker
                            @click="onMustahiqMarkerClick(mustahiq)"
                            :icon="icons.person_red"
                            :position="{ lat: mustahiq.latitude, lng: mustahiq.longitude }"
                            :key="`mustahiq_${mustahiq.id}`"
                            />

                        <GmapInfoWindow
                            :position="{lat: mustahiq.latitude, lng: mustahiq.longitude}"
                            :opened="mustahiq.info_window_opened"
                            @closeclick="mustahiq.info_window_opened=false"
                            :key="`mustahiq_info_${mustahiq.id}`"
                            >
                            <div>
                                <h4> Mustahiq </h4>
                                <p>{{ mustahiq.name }}</p>
                                <p>{{ mustahiq.address }}</p>
                            </div>
                        </GmapInfoWindow>
                    </template>

                </template>
            </GmapMap>
        </div>
    </div>
</template>

<script>

import icons from '../icons.js'
import { getDistance } from '../helpers.js'

export default {
    props: [
        "collectors",
        "gmap_settings",
    ],

    mounted() {
        this.$refs.mapRef.$mapPromise.then(map => {
            this.map = map

            // Load Geocoder Service
            this.geocoder = new google.maps.Geocoder;

            // Load Directions Service and Display
            this.directionsService = new google.maps.DirectionsService()
            this.directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true, preserveViewport: true})
            this.directionsDisplay.setMap(map);
        })

        this.loadAndSetCurrentLocation()
    },

    data() {

        let default_center = this.gmap_settings.center

        return {
            icons,
            pointer_marker: default_center,
            pointer_address: null,

            p_collectors: this.collectors.map(collector => {
                let prepared_mustahiqs = 
                    collector.mustahiqs.map(mustahiq => ({
                        ...mustahiq,
                        info_window_opened: false,
                        distance_from_collector: getDistance(mustahiq.latitude, mustahiq.longitude, collector.latitude, collector.longitude)
                    }))
                
                return {
                    ...collector,
                    info_window_opened: false,
                    donation_counts: [],
                    // muzakkis: collector.muzakkis.map(muzakki => ({...muzakki, info_window_opened: false })),
                    mustahiqs: prepared_mustahiqs,
                    nearest_mustahiq: prepared_mustahiqs.reduce((acc, cur) =>
                        acc.distance_from_collector <= cur.distance_from_collector ? acc : cur
                    ),
                }
            }),

            nearest_collector: this.collectors.reduce((acc, cur) => {
                return getDistance(acc.latitude, acc.longitude, default_center.lat, default_center.lng) <=
                       getDistance(cur.latitude, cur.longitude, default_center.lat, default_center.lng) ? acc : cur
            }),

            route_steps: [],
        }
    },

    watch: {
        pointer_marker(pointer_marker) {
            // Determine the nearest collector
            this.nearest_collector = this.p_collectors.reduce((acc, cur) => {
                return getDistance(acc.latitude, acc.longitude, pointer_marker.lat, pointer_marker.lng) <=
                       getDistance(cur.latitude, cur.longitude, pointer_marker.lat, pointer_marker.lng) ? acc : cur
            })

            // Reverse geocode current pointer's location to determine its real world address
            this.loadAndSetCurrentAddress(
                pointer_marker.lat,
                pointer_marker.lng
            )

            // Display route from the current pointer location to the nearest collector
            this.loadAndDisplayRouteOnMap(this.pointer_marker, {
                lat: this.nearest_collector.latitude,
                lng: this.nearest_collector.longitude
            })
        }
    },

    methods: {
        onMapClick(e) {
            this.pointer_marker = {
                lat: e.latLng.lat(),
                lng: e.latLng.lng(),
            }
        },

        // onMuzakkiMarkerClick(muzakki) {
        //     this.p_collectors.forEach(collector => {
        //         collector.muzakkis.forEach(o_muzakki => {
        //             o_muzakki.info_window_opened = (muzakki.id === o_muzakki.id)
        //         })
        //     })
        // },

        onMustahiqMarkerClick(mustahiq) {
            this.p_collectors.forEach(collector => {
                collector.mustahiqs.forEach(o_mustahiq => {
                    o_mustahiq.info_window_opened = (mustahiq.id === o_mustahiq.id)
                })
            })
        },

        onCollectorMarkerClick(collector) {
            this.p_collectors.forEach(o_collector => {
                o_collector.info_window_opened = (o_collector.id === collector.id)
            })

            this.loadDonationCount(collector)
        },

        loadAndSetCurrentLocation() {
            navigator.geolocation.getCurrentPosition(position => {
                this.pointer_marker.lat = position.coords.latitude
                this.pointer_marker.lng = position.coords.longitude

                this.loadAndSetCurrentAddress(this.pointer_marker.lat, this.pointer_marker.lng)
            })
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