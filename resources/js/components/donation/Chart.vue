<template>
    <div class="card mb-3">
        <div class="card-body">
            <donation-base-chart
                name='chart'
                title='Perkembangan Jumlah Nominal Pemberian Zakat (Dalam Jutaan Rupiah)'
                :data="donations"/>
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
            donations: window.donations
        }
    },

    methods: {
        numeral: numeral
    }
}
</script>
