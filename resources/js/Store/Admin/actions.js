export default {
    login({ commit }) {
        let user = localStorage.getItem("user");
        user = JSON.parse(user);
        let userData = user.user_data;
        userData.permissions = user.permissions;

        commit("login", { user: userData });
    }, //end of loggingin

    logout({ commit }) {
        localStorage.removeItem("user");
        commit("logout");
    }, //end of logout
};
