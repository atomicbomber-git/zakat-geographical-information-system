<template>
    <div class="card">
        <div class="card-header">
            <i class="fa fa-map"></i>
            Peta Persebaran UPZ, Muzakki, dan Mustahiq
        </div>

        <div class="card-body">
            <GmapMap
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

                <!-- Collector Markers -->
                <template v-for="collector in p_collectors">
                    <GmapMarker
                        :icon="icons.mosque_black"
                        :position="{ lat: collector.latitude, lng: collector.longitude }"
                        :key="collector.id"
                        />

                    <!-- Muzakki Markers and Info Windows -->
                    <template v-for="muzakki in collector.muzakkis">
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
                    </template>

                    <!-- Mustahiq Markers -->
                    <template v-for="mustahiq in collector.mustahiqs">
                        <GmapMarker
                            @click="onMustahiqMarkerClick(mustahiq)"
                            :icon="icons.person_green"
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

export default {
    props: [
        "collectors",
        "gmap_settings",
    ],

    data() {
        return {
            icons,
            pointer_marker: this.gmap_settings.center,
            p_collectors: this.collectors.map(collector => ({
                ...collector,
                info_window_opened: false,
                muzakkis: collector.muzakkis.map(muzakki => ({...muzakki, info_window_opened: false })),
                mustahiqs: collector.mustahiqs.map(mustahiq => ({...mustahiq, info_window_opened: false }))
            }))
        }
    },

    methods: {
        onMapClick(e) {
            this.pointer_marker = {
                lat: e.latLng.lat(),
                lng: e.latLng.lng(),
            }
        },

        onMuzakkiMarkerClick(muzakki) {
            this.p_collectors.forEach(collector => {
                collector.muzakkis.forEach(o_muzakki => {
                    if (muzakki.id === o_muzakki.id) {
                        o_muzakki.info_window_opened = true
                    }
                    else {
                        o_muzakki.info_window_opened = false
                    }
                })
            })
        },

        onMustahiqMarkerClick(mustahiq) {
            this.p_collectors.forEach(collector => {
                collector.mustahiqs.forEach(o_mustahiq => {
                    if (mustahiq.id === o_mustahiq.id) {
                        o_mustahiq.info_window_opened = true
                    }
                    else {
                        o_mustahiq.info_window_opened = false
                    }
                })
            })
        }
    },
}
</script>

<style>

</style>
