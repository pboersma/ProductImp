import { Commit } from 'vuex';
import { DataSource, getAll, create } from '../../services/DataSourceService';

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
      const dataSources = await getAll();
      console.log(dataSources);

      // TODO: Make sure to reject the Promise at some point.
      return new Promise((resolve, reject) => {
        commit('SET_DATASOURCES', dataSources);

        resolve(dataSources);
      });
    },

    // eslint-disable-next-line no-empty-pattern
    async create({ commit }: { commit: Commit }, payload: DataSource) {
      return new Promise((resolve, reject) => {
        const response = create(payload);

        // If the store is false, reject.
        if (!response) {
          reject(response);
        }

        const dataSources = getAll();
        commit('SET_DATASOURCES', dataSources);

        resolve(response);
      });
    },
  },
};
