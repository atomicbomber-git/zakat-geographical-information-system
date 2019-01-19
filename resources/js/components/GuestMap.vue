<template>
    <div>
        <div class="card mb-3">
            <div class="card-body">
                <guest-chart
                    :receivers_count="receivers_count"
                    :collectors_count="collectors_count"
                    />
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <i class="fa fa-map"></i>
                Peta Persebaran Unit Pengumpulan Zakat
            </div>
            <div class="card-body">
                <div>
                    <div>
                        <h4>
                            Lokasi Anda sekarang adalah: {{ this.pointer_marker.lat }}, {{ this.pointer_marker.lng }}
                        </h4>

                        <div class="alert alert-info">
                            <h4> Unit Pengumpulan Zakat terdekat dengan Anda: </h4>
                            <p>
                                <strong> {{ sortedDistances[0].name }} </strong>
                                {{ sortedDistances[0].address }} ({{ this.nearestDistance }})
                            </p>
                        </div>

                        <GmapMap
                            ref="mapRef"
                            :center="{lat:-0.026330, lng:109.342504}"
                            :zoom="14"
                            @click="moveMarker"
                            map-type-id="terrain"
                            style="width: 100%; height: 640px">

                            <span
                                v-for="collector in collectors"
                                :key="collector.id">

                                <GmapMarker
                                    :position="{lat: collector.latitude, lng: collector.longitude}"
                                    icon="/png/mosque.png"
                                    @click="onMarkerClick(collector)">
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
                                            
                                                <hr>

                                                <h5 class="mb-2"> Penerima Zakat Terdekat: </h5>
                                                <p class="mb-1" v-for="receiver in collector.nearestReceivers" :key="receiver.id">
                                                    {{ receiver.name }}, {{ receiver.address }}
                                                </p>
                                            
                                            </div>
                                        </div>
                                    </div>
                                </GmapInfoWindow>

                            </span>

                            <span v-for="receiver in receivers"
                                :key="'R' + receiver.id">
                                <GmapMarker
                                    :position="{lat: receiver.latitude, lng: receiver.longitude}"
                                    icon="/png/person.png"
                                    @click="onReceiverMarkerClick(receiver)">
                                </GmapMarker>

                                <GmapInfoWindow
                                    :position="{lat: receiver.latitude, lng: receiver.longitude}"
                                    :opened="receiver.isInfoWindowOpen"
                                    @closeclick="receiver.isInfoWindowOpen=false">
                                    <div>
                                        <div class="card">
                                            <div class="card-body">
                                                <h5> {{ receiver.name }} </h5>
                                                <p style="margin-bottom: 0px"> {{ receiver.address }} </p>
                                            </div> 
                                        </div>
                                    </div>
                                </GmapInfoWindow>
                            </span>

                            <GmapMarker
                                :position="this.pointer_marker">
                            </GmapMarker>
                        </GmapMap>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {gmapApi} from 'vue2-google-maps'

export default {
    mounted() {
        this.$refs.mapRef.$mapPromise.then((map) => {
            this.map = map
            this.directionsService = new google.maps.DirectionsService()
            this.directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true})
            this.distanceMatrixService = new google.maps.DistanceMatrixService();
            this.directionsDisplay.setMap(map);

            navigator.geolocation.getCurrentPosition(position => {
                this.pointer_marker.lat = position.coords.latitude
                this.pointer_marker.lng = position.coords.longitude
            })
        })
    },

    data() {
        return {
            pointer_marker: {lat:-0.026330, lng:109.342504},

            receivers_count: window.receivers_count,
            collectors_count: window.collectors_count,
            
            collectors: window.collectors.map(collector => {
                return {
                    ...collector,
                    isInfoWindowOpen: false,
                    nearestReceivers: [],
                }
            }),

            receivers: window.receivers.map(receiver => {
                return {
                    ...receiver,
                    isInfoWindowOpen: false
                }
            }),

            nearestDistance: null
        }
    },

    computed: {
        distances() {
            return this.collectors.map(collector => {
                return {
                    ...collector,
                    distance: this.getDistanceFromLatLonInKm(this.pointer_marker.lat, this.pointer_marker.lng, collector.latitude, collector.longitude)
                }
            })
        },

        sortedDistances() {
            return this.distances.sort((a, b) => { return a.distance - b.distance })
        },

        google: gmapApi
    },

    watch: {
        sortedDistances(locationDistances) {

            let nearestLocation = locationDistances[0]
            let travelMode = 'DRIVING'

            // Create a directions request
            let directionRequest = {
                origin: new google.maps.LatLng(this.pointer_marker),
                destination: new google.maps.LatLng({lat: nearestLocation.latitude, lng: nearestLocation.longitude}),
                travelMode: travelMode
            }

            let distanceRequest = {
                origins: [directionRequest.origin],
                destinations: [directionRequest.destination],
                travelMode: travelMode
            }

            this.distanceMatrixService.getDistanceMatrix(distanceRequest, (response, status) => {
                if (status != 'OK') { return }
                this.nearestDistance = response.rows[0].elements[0].distance.text
            })

            this.directionsService.route(directionRequest, (result, status) => {
                if (status != 'OK') { return }
                this.directionsDisplay.setDirections(result)
            });
        }
    },

    methods: {
        moveMarker(e) {
            this.pointer_marker = {
                lat: e.latLng.lat(),
                lng: e.latLng.lng()
            }
        },

        onMarkerClick(collector) {
            this.collectors = this.collectors.map(c => {
                if (c.id == collector.id) {

                    let nearestReceivers = []

                    // Calculate distance with all receiver
                    receivers.forEach(receiver => {
                        let distance = this.getDistanceFromLatLonInKm(
                            receiver.latitude, receiver.longitude,
                            collector.latitude, collector.longitude
                        )

                        if (distance <= 0.5) {
                            nearestReceivers.push(receiver)
                        }
                    })

                    return {...c, isInfoWindowOpen: true, nearestReceivers: nearestReceivers}
                }

                return {...c, isInfoWindowOpen: false}
            })
        },

        onReceiverMarkerClick(receiver) {
            this.receivers = this.receivers.map(c => {
                if (c.id == receiver.id) { return {...c, isInfoWindowOpen: true} }
                return {...c, isInfoWindowOpen: false }
            })
        },

        getDistanceFromLatLonInKm(lat1,lon1,lat2,lon2) {
            let R = 6371 // Radius of the earth in km
            let dLat = this.deg2rad(lat2-lat1)  // deg2rad below
            let dLon = this.deg2rad(lon2-lon1) 
            let a = 
                Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.cos(this.deg2rad(lat1)) * Math.cos(this.deg2rad(lat2)) * 
                Math.sin(dLon/2) * Math.sin(dLon/2); 
            let c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
            let d = R * c;
            return d;
        },

        deg2rad(deg) {
            return deg * (Math.PI/180)
        }
    }
}
</script>
