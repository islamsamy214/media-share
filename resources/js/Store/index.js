import { createStore } from "vuex";
import admin from "./Admin/index";
import web from "./Web/index";
// Create a new store instance.
const store = createStore({
    namespaced: true,

    state() {
        return {
            message: null,
            confirm: {
                message: null,
                answer: null,
            },
        };
    },
    modules: {
        web,
        admin,
    },
    mutations: {
        //alert message
        setMessage(state, payload) {
            state.message = payload.message;
        }, //end of flash message

        clearMessage(state) {
            state.message = null;
        }, //end of clearFlashMessage

        //alert comfirm message
        setConfirmMessage(state, payload) {
            state.confirm.message = payload.message;
        }, //end of setMessage

        clearConfirmMessage(state) {
            state.confirm.message = null;
            state.confirm.answer = null;
        }, //end of clearMessage

        setConfirmAnswer(state, payload) {
            state.confirm.answer = payload.answer;
        }, //end of setAnswer
    },
    getters: {
        //alet message
        getMessage(state) {
            return state.message;
        }, //end of getMessage

        isSetMessage(state) {
            if (state.message) {
                return true;
            }
            return false;
        }, //end of isSetMessage

        //alert comfirm message
        getConfirmMessage(state) {
            return state.confirm.message;
        }, //end of getMessage

        isSetConfirmMessage(state) {
            if (state.confirm.message) {
                return true;
            }
            return false;
        }, //end of isSetMessage

        getConfirmAnswer(state) {
            return state.confirm.answer;
        }, //end of getConfirmAnswer
    },
    actions: {
        //alert message
        flashMessage({ commit }, payload) {
            commit("setMessage", payload);
            setTimeout(() => {
                commit("clearMessage");
            }, 3000);
        }, //end of flashMessage

        //alert comfirm message
        askConfirmMessage({ commit }, payload) {
            commit("setConfirmMessage", payload);
        }, //end of confirmMessage

        answerConfirmMessage({ commit }, payload) {
            commit("setConfirmAnswer", payload);
            setTimeout(() => {
                commit("clearConfirmMessage");
            }, 1);
        }, //end of asnwerConfirmMessage
    },
});

export default store;
