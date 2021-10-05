export default {
    login(state, payload) {
        state.user = payload.user;
    },//end of login

    logout(state){
        state.user = null
    }//end of logout
};
