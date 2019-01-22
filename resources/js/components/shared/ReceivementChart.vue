<template>
    <div>
        <vue-frappe
            v-if="data.length !== 0"
            :id="name"
            :labels="data.map(record => record.year)"
            :title="title"
            type="bar"
            :colors="['blue', 'violet', 'red', 'orange']"
            :dataSets="[
                {
                    name: 'Zakat',
                    values: data.map(record => parseFloat(record.zakat / 1000000) )
                },
                {
                    name: 'Fitrah',
                    values: data.map(record => parseFloat(record.fitrah / 1000000) )
                },
                {
                    name: 'Infak',
                    values: data.map(record => parseFloat(record.infak / 1000000) )
                },
                {
                    name: 'Total',
                    values: data.map(record => parseFloat(record.total / 1000000) )
                },
            ]"
            
            :tooltipOptions="{
                formatTooltipX: d => (d + '').toUpperCase(),
                formatTooltipY: d => `${numeral(d * 1000000).format('$ 0.[000] a')}`,
                }"/>

        <div v-if="data.length == 0" class="alert alert-warning">
            <i class="fa fa-warning"></i>
            Grafik tidak dapat ditampilkan karena data tidak tersedia.
        </div>
    </div>
</template>

<script>
import numeral from 'numeral'

export default {
    props: ['data', 'name', 'title'],
    methods: {
        numeral: numeral
    }
}
</script>

<style>

</style>
