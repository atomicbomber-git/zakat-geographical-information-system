// Helper functions

import numeral from 'numeral'

// Convert degree to radian
export function deg2rad(deg) {
    return deg * (Math.PI / 180)
}

// Returns distance in kilometers
export function getDistance(lat1, lon1, lat2, lon2) {
    let R = 6371 // R = Radius bumi dalam satuan KM
    let dLat = deg2rad(lat2 - lat1) // dLat diisi dengan selisih dari lat2 dan lat1 yang telah dikonversi ke satuan radian dari satuan derajat
    let dLon = deg2rad(lon2 - lon1) // dLon diisi dengan selisih dari lon2 dan lon1 yang telah dikonversi ke satuan radian dari satuan derajat
    let a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) + // Sin (dLat / 2) * Sin(dLat / 2) +
        Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * // Cos (lat1) * Cos(lat2) *
        Math.sin(dLon / 2) * Math.sin(dLon / 2); // Sin(dLon / 2) * Sin(dLon / 2)
    let c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a)); // c = 2 * ArcTan(Akar(A), Akar(1 - A))
    let d = R * c; // d (jarak) = R (radius bumi) * c
    return d;
}

export function numberFormat(value) {
    let oldLocale = numeral.locale()
    numeral.locale('en')
    let result = numeral(value).format("0,0[.000]")
    numeral.locale(oldLocale)
    return result
}

export function currencyFormat(value) {
    let oldLocale = numeral.locale()
    numeral.locale('en')
    let result = numeral(value).format("0,0")
    numeral.locale(oldLocale)
    return result
}

export function numberNormalize(value) {
    let oldLocale = numeral.locale()
    numeral.locale('en')
    let result = numeral(value).value()
    numeral.locale(oldLocale)
    return result
}

export default { getDistance, deg2rad, numberFormat, numberNormalize }