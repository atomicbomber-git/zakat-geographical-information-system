<template>
    <div class="card mb-3">
        <div class="card-body">
            <receivement-base-chart
                name='chart'
                title='Perkembangan Jumlah Nominal Penerimaan Zakat (Dalam Jutaan Rupiah)'
                :data="receivements"/>
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
