<template>
  <div class="bg-gray-200">
    <ProductsPage v-if="currentPage === 'products'"></ProductsPage>
    <DataSourcesPage v-if="currentPage === 'datasources'"></DataSourcesPage>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import store from '@/store';
import ProductsPage from './Pages/ProductsPage.vue';
import DataSourcesPage from './Pages/DataSourcesPage.vue';

const currentPage = computed(() => store.getters['navigation/currentPage']);
</script>
