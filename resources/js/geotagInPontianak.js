import { debounce } from 'lodash'

export default debounce(function(data) {
    const geocoder = data.geocoder
    const searchQuery = data.searchQuery
    const onBegin = data.onBegin
    const onFinish = data.onFinish

    if (searchQuery == "") {
        return
    }

    let geocodingRequest = {
        address: searchQuery,
        componentRestrictions: {
            country: 'Indonesia',
            administrativeArea: 'Kota Pontianak',
            locality: 'Kota Pontianak',
        },
    }

    onBegin()
    geocoder.geocode(geocodingRequest, onFinish)
}, 200)