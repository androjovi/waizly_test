import helper from '../assets/js/helper.js'
import { boot } from 'quasar/wrappers'

export default boot (({ app }) => {
    app.config.globalProperties.$helper = helper
})

export { helper }