<script setup lang="ts">
import { ref, reactive, onMounted } from 'vue'
import { VDataTable } from 'vuetify/labs/VDataTable'

// Store
import { useProductStore } from '@/stores/product'

const itemsPerPage = ref(10)
const search = ref('')

const product = useProductStore()

const headers = reactive([
  {
    title: 'Datasource',
    key: 'datasource'
  },
  {
    title: 'Product',
    key: 'name'
  }
])

const loading = ref(true)

onMounted(async () => {
  await product.fetchAll()
  loading.value = false
})
</script>
<template>
  <v-text-field
    v-model="search"
    append-icon="mdi-magnify"
    label="Search"
    single-line
    hide-details
  ></v-text-field>
  <v-data-table
    v-if="!loading"
    v-model:items-per-page="itemsPerPage"
    dense
    :headers="headers"
    :items="product.products"
    item-value="name"
    :search="search"
    class="elevation-1"
  ></v-data-table>
</template>
