<template>
    <vue-frappe
        id="test"
        :labels="[
            'Penerima', 'Pengumpul'
        ]"
        title="Perbandingan Jumlah Penerima Zakat dan Unit Pengumpul Zakat"
        type="percentage"
        :colors="['blue', 'red']"
        :dataSets="this.data">
    </vue-frappe>
</template>

<script>
export default {
    props: ['receivers_count', 'collectors_count'],

    data () {
        return {
            data: [
                { values: [receivers_count, collectors_count] },
            ]
        }
    }
}
</script>

<style>

</style>
