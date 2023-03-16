<script setup lang="ts">
// Store
import { useNavigationStore } from '@/stores/navigation'

const navigation = useNavigationStore()
</script>
<template>
  <v-toolbar prominent color="primary">
    <v-toolbar-title>ProductImp</v-toolbar-title>
    <div v-if="navigation.isAuthorized">
      <v-btn @click="navigation.setPage('ProductsPage')">Products</v-btn>
      <v-btn @click="navigation.setPage('DatasourcesPage')">Datasources</v-btn>
    </div>
  </v-toolbar>
</template>
