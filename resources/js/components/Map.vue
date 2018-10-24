<template>
    <GmapMap
        :center="{lat:-0.026330, lng:109.342504}"
        :zoom="14"
        map-type-id="terrain"
        style="width: 100%; height: 640px">
    </GmapMap>
</template>

<script>
export default {
    mounted() {
        console.log("Component mounted.")
    }
}
</script>
