import Alpine from 'alpinejs'
// import 'tw-elements'

require('./bootstrap')
window.Alpine = Alpine
window.$ = window.jQuery = require('jquery')
Alpine.start()
