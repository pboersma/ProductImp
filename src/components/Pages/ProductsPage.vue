<template>
    <ProductInfoModal
    v-if="currentProduct"
    :current-product="currentProduct"
    :visible="isProductInfoModalVisible"
    @close-product-info-modal="toggleProductInfoModal()"
  >
  </ProductInfoModal>
  <ProductMap
    v-if="currentProduct"
    :current-product="currentProduct"
    :visible="isProductMapModalVisible"
    @close-product-map-modal="toggleProductMapModal()"
  >
  </ProductMap>
  <div class="container mx-auto px-5 pt-10" >
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
            <th scope="col" class="px-6 py-3">Name</th>
            <th scope="col" class="px-6 py-3">Synced</th>
            <th scope="col" class="px-6 py-3">Mapped</th>
            <th scope="col" class="px-6 py-3">Actions</th>
          </tr>
        </thead>
        <tbody v-if="!loading">
          <tr
            v-for="record in productsMappings"
            v-bind:key="record.id"
            class="
              bg-white
              border-b
              dark:bg-gray-800 dark:border-gray-700
              hover:bg-gray-50
              dark:hover:bg-gray-600
            "
          >
            <td
              class="px-6 py-4 text-gray-900 dark:text-white"
              style="width: 1%"
            >
              <button @click="toggleProductInfoModal(record.product)">
                <font-awesome-icon icon="fa-regular fa-circle-question" />
              </button>
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
              {{ record.source }}
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
              {{ record.product.name }}
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
              <font-awesome-icon
                class="text-red-500"
                icon="fa-regular fa-circle-xmark"
              />
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
              <font-awesome-icon
                v-if="!record.map.length"
                class="text-red-500"
                icon="fa-regular fa-circle-xmark"
              />
              <font-awesome-icon
                v-if="record.map.length"
                class="text-green-500"
                icon="fa-regular fa-circle-check"
              />
            </td>
            <td class="px-6 py-4 flex">
              <button
                @click="
                  toggleProductMapModal({
                    ...record.product,
                    id: record.id,
                    map: record.map,
                  })
                "
                class="
                  font-medium
                  text-blue-600
                  dark:text-blue-500
                  hover:underline
                  mr-2
                "
                title="Configure Product with WooCommerce"
              >
                <font-awesome-icon icon="fa-solid fa-sliders" />
              </button>
              <button
                @click="syncProduct(record.id)"
                class="
                  font-medium
                  text-blue-600
                  dark:text-blue-500
                  hover:underline
                  mr-2
                "
                title="Sync to WooCommerce"
              >
                <font-awesome-icon icon="fa-solid fa-shop" />
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      <div v-if="loading" class="container w-full bg-gray-50 p-4">
          <img src="https://media.tenor.com/On7kvXhzml4AAAAj/loading-gif.gif" alt="spinner" class="h-8 m-auto d-block">
        </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed, onMounted, ref } from 'vue';
import store from '@/store';
import Swal from 'sweetalert2';
import { createWoocommerceProduct } from '../../services/WooCommerceService';
import ProductInfoModal from '../Modals/ProductInfoModal.vue';
import ProductMap from '../Modals/ProductMap.vue';

const loading = ref(true);
const currentProduct = ref();
const isProductInfoModalVisible = ref(false);
const isProductMapModalVisible = ref(false);

const products = computed(() => store.getters['products/allProducts']);
const mappings = computed(() => store.getters['products/allMappings']);
const wcProducts = computed(() => store.getters['products/allWoocommerce']);
const productsMappings: any = ref([]);

const fetchAll = () => {
  const promises = [
    store.dispatch('products/fetchAll'),
    store.dispatch('products/getMappings'),
  ];

  // TODO: Do something with the response & error.
  Promise.all(promises).then((response) => {
    productsMappings.value = products.value.map((item: any) => {
      if (!mappings.value) {
        return { ...item, map: [] };
      }

      const mapping = mappings.value.find((o: any) => o.product_id === item.id);

      // If no mapping is matched with the product, Return empty array.
      if (!mapping) {
        return { ...item, map: [] };
      }

      return { ...item, map: JSON.parse(mapping.map) };
    });

    Promise.resolve();
    loading.value = false;
  });
};

const isMapped = ref(false);

const toggleProductInfoModal = (product: string | null = null) => {
  currentProduct.value = product;
  isProductInfoModalVisible.value = !isProductInfoModalVisible.value;
};

const toggleProductMapModal = (product: string | null = null) => {
  currentProduct.value = product;
  isProductMapModalVisible.value = !isProductMapModalVisible.value;
};

const syncProduct = (id: string) => {
  Swal.fire({
    title: 'Synchronize product with WooCommerce',
    text: 'This will add the selected product to WooCommerce Product List.',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sync',
  }).then((result) => {
    console.log(result);
    if (result.isConfirmed) {
      createWoocommerceProduct(id);
      Swal.fire({
        icon: 'success',
        title: `Succesfully synced product: ${id}`,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
      });
    }
  });
};

onMounted(() => {
  fetchAll();
});
</script>
