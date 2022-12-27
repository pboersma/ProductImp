import { Commit } from 'vuex';
import { getAll } from '../../services/ProductService';

interface State {
  products: Array<unknown>
}

export default {
  namespaced: true,
  state: {
    products: [],
  },
  getters: {
    allProducts: (state: { products: Array<unknown>; }) => state.products.map(
      (product: any) => ({ source: product.datasource_id, product: JSON.parse(product.product) }),
    ),
  },
  mutations: {
    SET_PRODUCTS(state: State, payload: Array<unknown>) {
      state.products = payload;
    },
  },
  actions: {
    async fetchAll({ commit }: { commit: Commit }) {
      const products = await getAll();

      // TODO: Make sure to reject the Promise at some point.
      return new Promise((resolve, reject) => {
        commit('SET_PRODUCTS', products);

        resolve(products);
      });
    },
  },
};
