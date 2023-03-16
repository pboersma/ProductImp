<script setup lang="ts">
import { ref, reactive, onMounted } from 'vue'
import { VDataTableVirtual } from 'vuetify/labs/VDataTable'

// Store
import { useProductStore } from '@/stores/product'

const product = useProductStore()

const headers = reactive([
  {
    title: 'Name',
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
  <v-data-table-virtual
    v-if="!loading"
    dense
    :headers="headers"
    :items="product.products"
    item-value="name"
    class="elevation-1"
  ></v-data-table-virtual>
</template>
