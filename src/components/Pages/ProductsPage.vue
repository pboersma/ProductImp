<template>
  <div class="container mx-auto px-5 pt-10">
    <div class="mb-5 flex justify-between">
      <h2 class="text-2xl font-light">Products</h2>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead
          class="
            text-xs text-gray-700
            uppercase
            bg-gray-50
            dark:bg-gray-700 dark:text-gray-400
          "
        >
          <tr>
            <th scope="col" class="px-6 py-3"></th>
            <th scope="col" class="px-6 py-3">Source</th>
            <th scope="col" class="px-6 py-3">Brand</th>
            <th scope="col" class="px-6 py-3">Name</th>
            <th scope="col" class="px-6 py-3">EAN Code</th>
          </tr>
        </thead>
        <tbody v-if="!loading">
          <tr
            v-for="record in products"
            v-bind:key="record.product.EAN_Code"
            class="
              bg-white
              border-b
              dark:bg-gray-800 dark:border-gray-700
              hover:bg-gray-50
              dark:hover:bg-gray-600
            "
          >
            <td class="
                px-6
                py-4
                text-gray-900
                dark:text-white
              "
              style="width: 1%">
              <button @click="toggleProductInfoModal(record.product)">
                <font-awesome-icon icon="fa-regular fa-circle-question" />
              </button>
            </td>
            <td
              scope="row"
              class="
                px-6
                py-4
                font-medium
                text-gray-900
                dark:text-white
                whitespace-nowrap
              "
              style="width: 1%"
            >
              {{ record.source }}
            </td>
            <td
              scope="row"
              class="
                px-6
                py-4
                font-medium
                text-gray-900
                dark:text-white
                whitespace-nowrap
              "
              style="width: 1%"
            >
              {{ record.product.Merk }}
            </td>
            <td
              scope="row"
              class="
                px-6
                py-4
                font-light
                text-gray-900
                dark:text-white
                whitespace-nowrap
              "
            >
              {{ record.product.Productnaam_NL }}
            </td>
            <td class="px-6 py-4">
              {{ record.product.EAN_Code }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <ProductInfoModal
  v-if="currentProduct"
  :current-product="currentProduct"
  :visible="isProductInfoModalVisible"
  @close-product-info-modal="toggleProductInfoModal()"
  >
  </ProductInfoModal>
</template>

<script setup lang="ts">
import {
  computed, onMounted, ref,
} from 'vue';
import store from '@/store';
import ProductInfoModal from '../Modals/ProductInfoModal.vue';

const loading = ref(true);
const currentProduct = ref();
const isProductInfoModalVisible = ref(false);

const products = computed(() => store.getters['products/allProducts']);

const fetchAll = () => {
  const promises = [
    store.dispatch('products/fetchAll'),
  ];

  // TODO: Do something with the response & error.
  Promise.all(promises)
    .then((response) => {
      loading.value = false;
      Promise.resolve();
    });
};

const toggleProductInfoModal = (product: string | null = null) => {
  currentProduct.value = product;
  isProductInfoModalVisible.value = !isProductInfoModalVisible.value;
};

onMounted(() => {
  fetchAll();
});
</script>
