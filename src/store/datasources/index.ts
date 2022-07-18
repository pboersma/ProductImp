import { Commit } from 'vuex';
import { getAllDataSources } from '../../services/DataSourceService';

interface State {
  dataSources: Array<unknown>
}

export default {
  namespaced: true,
  state: {
    dataSources: [],
  },
  getters: {
    allDataSources: (state: { dataSources: Array<unknown>; }) => state.dataSources,
  },
  mutations: {
    SET_DATASOURCES(state: State, payload: Array<unknown>) {
      state.dataSources = payload;
    },
  },
  actions: {
    async fetchAll({ commit }: { commit: Commit }) {
      const dataSources = await getAllDataSources();

      // TODO: Make sure to reject the Promise at some point.
      return new Promise((resolve, reject) => {
        commit('SET_DATASOURCES', dataSources);

        resolve(dataSources);
      });
    },
  },
};
