import Vue from 'vue'
import SmoothVueBar from 'smooth-vuebar'
import {library} from '@fortawesome/fontawesome-svg-core'
import {faArrowLeft, faBoxOpen, faSearch, faTimes, faTrashAlt} from '@fortawesome/free-solid-svg-icons'
import {faUser} from '@fortawesome/free-regular-svg-icons'
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'
import {Dialog, Notification, Option, OptionGroup, Select} from 'element-ui'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'

import Pos from './PostComponent'

library.add(faArrowLeft, faBoxOpen, faSearch, faTimes, faTrashAlt, faUser)

locale.use(lang)

Vue.use(Dialog)
Vue.use(Option)
Vue.use(OptionGroup)
Vue.use(Select)
Vue.use(SmoothVueBar)

Vue.component('fa-icon', FontAwesomeIcon)

Vue.prototype.$notify = Notification

Vue.filter('currency', value => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
    }).format(value)
})

Vue.config.devtools = process.env.NODE_ENV === 'development'
Vue.config.productionTip = false

new Vue({
    render: h => h(Pos)
}).$mount('#app')
