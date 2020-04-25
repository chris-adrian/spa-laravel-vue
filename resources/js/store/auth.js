import axios from 'axios'

export default {
    namespaced: true,
    state: {
        token: null,
        user: null,
    },
    getters: {
        authenticated(state) {
            return state.token && state.user;
        },
        user(state) {
            return state.user;
        }
    },
    mutations: {
        SET_TOKEN(state, token) {
            state.token = token
        },
        SET_USER(state, data) {
            state.user = data
        }
    },
    actions: {
        async register({ dispatch }, credentials) {
            await axios.post('auth/register', credentials)
            .then(()=> {
                return dispatch('signIn', credentials);
            })
            .catch((err) => {
                throw err.response.data;
            });
        },
        async signIn({ dispatch }, credentials){ 
            await axios.post('auth/signin', credentials)
            .then((res) => {
                if(!credentials.check){
                    return dispatch('attempt', res.data.token);
                }
            })
            .catch((err) => {
                throw err.response.data;
            });
        },
        async attempt({commit, state}, token) {
            if (token) {
                commit('SET_TOKEN', token);    
            }
            if (!state.token) {
                return
            }
            try {
                await axios.get('auth/user').then((res) => {
                    commit('SET_USER', res.data);
                });
            } catch (e) {
                commit('SET_TOKEN', null);
                commit('SET_USER', null);
            }
        },
        signOut({commit, dispatch}) {
            return axios.post('auth/signout').then(()=>{
                commit('SET_TOKEN',null)
                commit('SET_USER',null)
                dispatch('user/initState',null, {root:true})
            })
            .catch(() => {
            });
        }
    }
}