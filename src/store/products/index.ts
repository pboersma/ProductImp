import { Commit } from 'vuex';
import { getAllProducts } from '../../services/ProductService';

interface State {
  products: Array<unknown>
}

export default {
  namespaced: true,
  state: {
    products: [],
  },
  getters: {
    allProducts: (state: { products: Array<unknown>; }) => state.products,
  },
  mutations: {
    SET_PRODUCTS(state: State, payload: Array<unknown>) {
      state.products = payload;
    },
  },
  actions: {
    async fetchAll({ commit }: { commit: Commit }) {
      const products = await getAllProducts();

      // TODO: Make sure to reject the Promise at some point.
      return new Promise((resolve, reject) => {
        commit('SET_PRODUCTS', products);

        resolve(products);
      });
    },
  },
};
