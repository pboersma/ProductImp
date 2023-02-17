<template>
  <div class="bg-gray-200 pt-12">
    <ProductsPage v-if="currentPage === 'products'"></ProductsPage>
    <DataSourcesPage class="mt-20" v-if="currentPage === 'datasources'"></DataSourcesPage>
  </div>
</template>
<script setup lang="ts">
import { computed } from 'vue';
import store from '@/store';
import ProductsPage from './Pages/ProductsPage.vue';
import DataSourcesPage from './Pages/DataSourcesPage.vue';

const currentPage = computed(() => store.getters['navigation/currentPage']);
</script>
