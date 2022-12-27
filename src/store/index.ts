import Vuex from 'vuex';
import authorization from './authorization';
import navigation from './navigation';
import datasources from './datasources';
import products from './products';

export default new Vuex.Store({
  modules: {
    authorization,
    navigation,
    datasources,
    products,
  },
});
