export default {
    methods: {
        loadAndSetupDatalayer(datasource_url) {
            this.map.data.loadGeoJson(datasource_url)

            this.map.data.setStyle({
                fillColor: 'lightgreen',
                clickable: false,
            })
        }
    }
}
