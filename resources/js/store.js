import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)


export default new Vuex.Store({
    state: {
        isEditingPrepStep: false,
        isEditingPrepIngredient: false,
        step: "",
        newPrepStatus: 0,
        newIngredientStatus: 0,
        ingreident: ""
    },
    mutations: {
        updateIsEditingPrepStep(state, payload) {
            state.isEditingPrepStep = payload
        },
        updateStep(state, payload) {
            state.step = payload
        },
        updateNewPrepStatus(state, payload) {
            state.newPrepStatus += 1
        },
        updateIsEditingIngredient(state, payload) {
            state.isEditingPrepIngredient = payload
        },
        updateIngredient(state, payload) {
            state.ingreident = payload
        },
        updateNewIngredientStatus(state, payload) {
            state.newIngredientStatus += 1
        },
    },
    actions: {}
})