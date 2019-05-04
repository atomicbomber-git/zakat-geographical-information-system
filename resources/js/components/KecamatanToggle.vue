<template>
    <div>
        <div class="custom-control custom-checkbox font-weight-bold mb-2">
            <input
                v-model="kecamatan.is_visible"
                type="checkbox"
                class="custom-control-input"
                :id="`checkbox_kecamatan_${kecamatan.name}`"
            >
            <label
                class="custom-control-label"
                :for="`checkbox_kecamatan_${kecamatan.name}`"
            >Kecamatan {{ kecamatan.name }}</label>
        </div>

        <div
            class="custom-control custom-checkbox ml-4"
            v-for="kelurahan in kecamatan.kelurahans"
            :key="kelurahan.name"
        >
            <input
                v-model="kelurahan.is_visible"
                type="checkbox"
                class="custom-control-input"
                :id="`checkbox_kelurahan_${kelurahan.name}`"
            >
            <label
                class="custom-control-label"
                :for="`checkbox_kelurahan_${kelurahan.name}`"
            >Kelurahan {{ kelurahan.name }}</label>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        "value",
    ],

    data() {
        return {
            kecamatan: {
                ...this.value,
                kelurahans: [...this.value.kelurahans],
            }
        }
    },

    watch: {
        "kecamatan.is_visible": function(new_val) {
            this.kecamatan.kelurahans.forEach(kelurahan => {
                kelurahan.is_visible = this.kecamatan.is_visible
            });

            this.$emit("input", this.kecamatan)
        },

        "kecamatan.kelurahans": {
            handler: function() {
                this.$emit("input", this.kecamatan)
            },
            deep: true,
        }
    }
};
</script>