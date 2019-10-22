import numeral from 'numeral'

numeral.register('locale', 'id', {
    delimiters: {
        thousands: '.',
        decimal: ','
    },
    abbreviations: {
        thousand: 'Ribu',
        million: 'Juta',
        billion: 'Miliar',
        trillion: 'Triliun'
    },
    currency: {
        symbol: 'Rp.'
    }
});

numeral.locale('id')

export default numeral
