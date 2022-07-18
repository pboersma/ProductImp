import Vuex from 'vuex';
import authorization from './authorization';
import navigation from './navigation';
import datasources from './datasources';

export default new Vuex.Store({
  modules: {
    authorization,
    navigation,
    datasources,
  },
  actions: {
  },
  mutations: {},
});
