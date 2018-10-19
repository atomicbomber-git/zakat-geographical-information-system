<template>
    <div>
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

        </GmapMap>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        
        data() {
            return {
                pointer_marker: null
            }
        },

        methods: {
            moveMarker: function (e) {
                this.pointer_marker = {
                    lat: e.latLng.lat(),
                    lng: e.latLng.lng()
                }
            }
        }
    }
</script>
