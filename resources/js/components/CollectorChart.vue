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
                    name: 'Penerimaan',
                    values: data.map(record => parseFloat(record.donation / 1000000) )
                },
                {
                    name: 'Pemberian',
                    values: data.map(record => parseFloat(record.report / 1000000) )
                },
            ]"
            :tooltipOptions="{
                formatTooltipX: d => (d + '').toUpperCase(),
                formatTooltipY: d => `${numeral(d * 1000000).format('$ 0.[000] a')}`,
                }"
        />

        <div v-if="data.length == 0" class="alert alert-warning">
            <i class="fa fa-warning"></i>
            Grafik tidak dapat ditampilkan karena data tidak tersedia.
        </div>
    </div>
</template>

<script>
import numeral from "numeral";

export default {
    props: ["data", "name", "title"],
    methods: {
        numeral: numeral
    }
};
</script>
