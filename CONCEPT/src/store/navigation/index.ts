import { Commit } from 'vuex';

interface State {
  page: boolean
}

export default {
  namespaced: true,
  state: {
    page: 'products',
  },
  getters: {
    currentPage: (state: { page: string; }) => state.page,
  },
  mutations: {
    SET_PAGE(state: State, payload: boolean) {
      state.page = payload;
    },
  },
  actions: {
    setPage({ commit }: { commit: Commit }, id: string) {
      commit('SET_PAGE', id);
    },
  },
};
