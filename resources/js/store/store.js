import { createStore } from 'vuex'
import state from './state'
import getters from './getters'
import mutations from './mutations'
import actions from './actions'

export default createStore({
    state: state,
    mutations: mutations,
    getters: getters,
    actions: actions
})
