import { Commit } from 'vuex';
import { getAll, getMappings } from '../../services/ProductService';

interface State {
  products: Array<unknown>
  mappings: Array<unknown>
  woocommerceProducts: Array<unknown>
}

export default {
  namespaced: true,
  state: {
    products: [],
    mappings: [],
    woocommerceProducts: [],
  },
  getters: {
    allProducts: (state: { products: Array<unknown>; }) => state.products.map(
      (product: any) => ({
        id: product.id,
        source: product.datasource_id,
        product: JSON.parse(product.product),
      }),
    ),
    allMappings: (state: { mappings: Array<unknown>; }) => state.mappings,
    allWoocommerce: (state: { woocommerceProducts: Array<unknown>; }) => state.woocommerceProducts,
  },
  mutations: {
    SET_PRODUCTS(state: State, payload: Array<unknown>) {
      state.products = payload;
    },
    SET_MAPPINGS(state: State, payload: Array<unknown>) {
      state.mappings = payload;
    },
    SET_WOOCOMMERCE(state: State, payload: Array<unknown>) {
      state.woocommerceProducts = payload;
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

    async getMappings({ commit }: { commit: Commit }) {
      const mappings = await getMappings();

      // TODO: Make sure to reject the Promise at some point.
      return new Promise((resolve, reject) => {
        commit('SET_MAPPINGS', mappings);

        resolve(mappings);
      });
    },
  },
};
