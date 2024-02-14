import { createStore } from 'vuex'
const store = createStore({
    state: {
        token: localStorage.getItem('token') || 0,
        conctactos: []
    },
    mutations: {
        setContactos(state, payload) {
            state.conctactos = payload;
        }
    },
    getters : {
        getToken(state){
            return state.token
        },
        getContactos(state){
            return state.conctactos
        }
    },
    actions: {
        
    }
});
export default store;