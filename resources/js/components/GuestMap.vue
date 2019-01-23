<template>
    <div>
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
                            :center="this.center"
                            :zoom="14"
                            @click="moveMarker"
                            map-type-id="terrain"
                            style="width: 100%; height: 640px">

                            <span
                                v-for="collector in collectors"
                                :key="collector.id">

                                <GmapMarker
                                    :position="{lat: collector.latitude, lng: collector.longitude}"
                                    :icon="(this.collector && this.collector.id == collector.id) ? '/png/mosque_red.png' : '/png/mosque.png'"
                                    @click="onMarkerClick(collector)">
                                </GmapMarker>

                                <span v-for="donation in collector.donations" :key="donation.id">
                                    <GmapMarker
                                        @click="donation.isInfoWindowOpen=true"
                                        :position="{lat: donation.latitude, lng: donation.longitude}"
                                        icon="/png/person.png"/>
                                    
                                    <GmapInfoWindow
                                        @closeclick="donation.isInfoWindowOpen=false"
                                        :position="{lat: donation.latitude, lng: donation.longitude}"
                                        :opened="donation.isInfoWindowOpen">
                                        {{ donation.name }}
                                    </GmapInfoWindow>
                                </span>


                                <GmapInfoWindow
                                    :position="{lat: collector.latitude, lng: collector.longitude}"
                                    :opened="collector.isInfoWindowOpen"
                                    @closeclick="collector.isInfoWindowOpen=false">
                                    <div>
                                        <div class="card" style="width: 25rem;">
                                            <img class="card-img-top" style="width: auto; height: auto; object-fit: cover" :src="collector.image_url" alt="Card image cap">
                                            <div class="card-body">
                                                <h5 class="card-title"> {{ collector.name }} </h5>
                                                <p class="card-text"> {{ collector.address }} </p>
                                                
                                                <hr>

                                                <vue-frappe
                                                    v-if="collector.donation_counts.length !== 0"
                                                    :id="`chart_${collector.id}`"
                                                    :labels="collector.donation_counts.map(record => record.year)"
                                                    title="Perkembangan Jumlah Penerima Zakat"
                                                    type="bar"
                                                    :dataSets="[{
                                                            name: 'Penerima Zakat',
                                                            values: collector.donation_counts.map(record => record.count)
                                                    }]"
                                                    
                                                    :tooltipOptions="{
                                                        formatTooltipX: d => (d + '').toUpperCase(),
                                                        formatTooltipY: d => d,
                                                    }"
                                                    >
                                                </vue-frappe>

                                                <hr>

                                                <p class="mb-2"> <strong> Penerima Zakat Terdekat: </strong> </p>
                                                <p class="mb-1" v-for="donation in collector.nearestDonations" :key="donation.id">
                                                    {{ donation.name }}, {{ donation.address }}
                                                </p>
                                            
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
            this.directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true, preserveViewport: true})
            this.distanceMatrixService = new google.maps.DistanceMatrixService();
            this.directionsDisplay.setMap(map);

            navigator.geolocation.getCurrentPosition(position => {
                this.pointer_marker.lat = position.coords.latitude
                this.pointer_marker.lng = position.coords.longitude
                
                if (!this.collector) {
                    this.center.lat = position.coords.latitude
                    this.center.lng = position.coords.longitude
                }
                
            })
        })
    },

    data() {

        let center = {lat:-0.026330, lng:109.342504}

        if (window.collector) {
            center.lat = window.collector.latitude
            center.lng = window.collector.longitude
        }

        return {
            center: center,
            pointer_marker: {lat:-0.026330, lng:109.342504},
            collector: window.collector,

            receivers_count: window.receivers_count,
            collectors_count: window.collectors_count,
            
            collectors: window.collectors.map(collector => {
                return {
                    ...collector,
                    isInfoWindowOpen: false,
                    donation_counts: [],
                    donations: collector.donations.map(donation => { return {...donation, isInfoWindowOpen: false } }),
                    nearestDonations: [],
                }
            }),

            nearestDistance: null
        }
    },

    computed: {
        donations() {
            return this.collectors.reduce((acc, collector) => {
                return [...acc, ...collector.donations]
            }, [])
        },

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
                    return {...c, isInfoWindowOpen: true}
                }
                return c;
            })

            axios.get(`/donation/api/count/${collector.id}`)
                .then((response) => {
                    this.collectors = this.collectors.map(c => {
                        if (c.id == collector.id) {
                            return {...c, donation_counts: response.data}
                        }
                        return c;
                    })
                })
                .catch()


            this.collectors = this.collectors.map(c => {
                if (c.id == collector.id) {

                    let nearestDonations = []

                    // Calculate distance with all receiver
                    this.donations.forEach(donation => {
                        let distance = this.getDistanceFromLatLonInKm(
                            donation.latitude, donation.longitude,
                            collector.latitude, collector.longitude
                        )

                        if (distance <= 0.5) {
                            nearestDonations.push(donation)
                        }
                    })

                    return {...c, isInfoWindowOpen: true, nearestDonations: nearestDonations}
                }

                return {...c, isInfoWindowOpen: false}
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
