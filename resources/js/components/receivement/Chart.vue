<template>
    <div class="card mb-3">
        <div class="card-body">
            <vue-frappe
                v-if="receivements.length !== 0"
                id="chart_receivements"
                :labels="receivements.map(receivement => receivement.year)"
                title="Perkembangan Jumlah Nominal Penerimaan Zakat (Dalam Jutaan Rupiah)"
                type="bar"
                :colors="['dark red', 'dark green', 'dark blue', 'dark purple']"
                :dataSets="[
                    {
                        name: 'Zakat',
                        values: receivements.map(receivement => parseFloat(receivement.zakat / 1000000) )
                    },
                    {
                        name: 'Fitrah',
                        values: receivements.map(receivement => parseFloat(receivement.fitrah / 1000000) )
                    },
                    {
                        name: 'Infak',
                        values: receivements.map(receivement => parseFloat(receivement.infak / 1000000) )
                    },
                    {
                        name: 'Total',
                        values: receivements.map(receivement => parseFloat(receivement.total / 1000000) )
                    },
                ]"
                
                :tooltipOptions="{
                    formatTooltipX: d => (d + '').toUpperCase(),
                    formatTooltipY: d => `${numeral(d * 1000000).format('$ 0.[000] a')}`,
                }"/>

                <div v-if="receivements.length == 0" class="alert alert-warning">
                    <i class="fa fa-warning"></i>
                    Grafik tidak dapat ditampilkan karena data tidak tersedia.
                </div>
        </div>
    </div>
</template>

<script>

import numeral from 'numeral'

export default {
    mounted() {
    },

    data() {
        return {
            receivements: window.receivements
        }
    },

    methods: {
        numeral: numeral
    }
}
</script>

<style>

</style>
