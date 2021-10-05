export default {
    getUser(state) {
        return state.user;
    }, //end of getuser

    isLoggedIn(state) {
        if (state.user) {
            return true;
        }
        return false;
    },//end of isLoggedIn
};
