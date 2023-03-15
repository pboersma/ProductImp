import { Commit } from 'vuex';
import { isAuthorized } from '../../services/AuthService';

interface State {
  authorized: boolean
}

export default {
  namespaced: true,
  state: {
    authorized: false,
  },
  getters: {
    isAuthorized: (state: { authorized: boolean; }) => state.authorized,
  },
  mutations: {
    SET_AUTHORIZED(state: State, payload: boolean) {
      state.authorized = payload;
    },
  },
  actions: {
    async authorized({ commit }: { commit: Commit }) {
      // Check if user is Authorized to use ProductImp with WooCommerce.
      const response = await isAuthorized();

      // TODO: Make sure to reject the Promise at some point.
      return new Promise((resolve, reject) => {
        commit('SET_AUTHORIZED', response);

        resolve(response);
      });
    },
  },
};
