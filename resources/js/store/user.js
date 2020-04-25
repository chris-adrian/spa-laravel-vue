import axios from 'axios'

export default {
    namespaced: true,
    state: {
        profile: false,
        profileExtension: undefined,
        authorization: undefined
    },
    mutations: {
        SET_PROFILE(state, validity) {
            state.profile = validity
        },
        SET_PROFILEEXT(state, info) {
            state.profileExtension = info
        },
        SET_AUTHORIZATION(state, level) {
            state.authorization = level
        },
        RESET_STATE(state){
            state.profile = false;
            state.profileExtension = undefined;
            state.authorization = undefined;
        }
    },
    actions: {
        async getInfo({ commit, dispatch },credentials) {
            dispatch('initState',null);
            // await axios.post('user/getInfo', {
            //     // params: {
            //         username: username
            //     // }
            // })
            await axios.post('user/getInfo', credentials)
            .then((res) => {
                // response = res.data;
                commit('SET_PROFILE', res.data.profile);
                if(res.data.profileExtension) {
                    commit('SET_PROFILEEXT', res.data.profileExtension)
                }
                commit('SET_AUTHORIZATION', res.data.authorization);
                // return res;
            })
            .catch((err) => {
                throw err.response.data;
                // console.log(err)
            });
        },
        async updateProfile({dispatch}, credentials) {
            // console.log(this.state.auth.token)
            let response;
            await axios.post('profile/update', credentials)
            .then((res)=> {
                response = res.data;
                dispatch('auth/attempt', this.state.auth.token,{root:true})
            })
            .catch((err)=> {
                throw err.response.data;
            });
            return response;
        },
        async updateProfileImage({dispatch}, data) {
            let response;
            await axios.post('profile/image', data, {
                onUploadProgress : uploadEvent => {
                  console.log('upload progress : ' + Math.round(uploadEvent.loaded / uploadEvent.total * 100) + '%')
                }
            })
            .then((res)=> {
                response = res.data;
            })
            .catch((err)=> {
                throw err.response.data;
            });
            return response;
        },
        async updateAccount({ dispatch },credentials) {
            let response;
            await axios.post('user/update', credentials)
            .then((res)=> {
                let pass = credentials.newPassword ? credentials.newPassword : credentials.password 
                dispatch('auth/signIn', {
                    //Reauthenticate with updated credentials
                    username: credentials.username,
                    password: pass
                    }, {root:true});
                response = res;
            })
            .catch((err) => {
                throw err.response.data;
            });
            return response;
        },
        async account() {
            let response;
            await axios.post('user/account', null)
            .then((res)=>{
                return response = res.data;
            })
            .catch((err)=>{
                throw err.response.data;
            });
            return response;
        },
        initState({commit}) {
            commit('RESET_STATE')
            // console.log('resetting state')
        }
    }
}