<script setup lang="ts">
// @ts-nocheck
import { ref, reactive, onMounted } from 'vue'
import { VDataTable } from 'vuetify/labs/VDataTable'
import Swal from 'sweetalert2'

import LoadingPage from '@/components/pages/LoadingPage.vue'

// Store
import { useProductStore } from '@/stores/product'
import { useMappingStore } from '@/stores/mapping'
import { useWoocommerceStore } from '@/stores/woocommerce'
import { useDialogStore } from '@/stores/dialog'

const productStore = useProductStore()
const dialogStore = useDialogStore()
const mappingStore = useMappingStore()
const wooCommerceStore = useWoocommerceStore()

const products = ref()

// Datatable
const itemsPerPage = ref(10)
const search = ref('')
const expanded = ref([])
const headers = reactive([
  {
    title: '',
    sortable: false,
    key: 'data-table-expand'
  },
  {
    title: 'Product',
    key: 'name'
  },
  {
    title: 'Mapped',
    key: 'mapped'
  },
  {
    title: 'Synced',
    key: 'synced'
  },
  {
    title: 'Actions',
    key: 'actions',
    sortable: false
  }
])

// General
const loading = ref(true)

const checkStatus = (item: any) => {
  if(!item.mapped) {
    return true;
  }
  
  if(item.synced) {
    return true;
  }

  return false;
}

const save = async (id: any) => {
  await Swal.fire({
  title: 'Do you want to sync this product to WooCommerce?',
  showCancelButton: true,
  confirmButtonText: 'Yes, sync it!',
}).then(async (result) => {
  /* Read more about isConfirmed, isDenied below */
  if (result.isConfirmed) {
    await wooCommerceStore.save(id)
    await Swal.fire('Synced!', '', 'success')
  }
})
}

onMounted(async () => {
  await productStore.fetchAll()
  await mappingStore.fetchAll()
  await wooCommerceStore.fetchAll()

  if (productStore.products) {
    if (mappingStore.mappings || wooCommerceStore.woocommerceProducts) {
      products.value = productStore.products.map((item: any) => {
        const mapping = mappingStore.mappings.find((mapping: any) => mapping.product_id === item.id)
        const woocommerce = wooCommerceStore.woocommerceProducts.find((woocommerce: any) => woocommerce.product_id === item.id)

        let mutatedItem = { ...item}

        if (mapping) {
          mutatedItem = { ...mutatedItem, mapping: JSON.parse(mapping.map), mapped: true }
        }

        if(woocommerce) {
          mutatedItem = { ...mutatedItem, synced: true }
        }

        return mutatedItem
      })
    }
  }

  loading.value = false
})
</script>
<template>
  <v-card v-if="!loading">
    <v-card-title>
      <v-text-field v-model="search" label="Search" single-line hide-details></v-text-field>
    </v-card-title>
    <v-data-table
      v-model:expanded="expanded"
      v-model:items-per-page="itemsPerPage"
      dense
      :headers="headers"
      :items="products"
      item-value="name"
      :search="search"
      class="elevation-1"
    >
      <template v-slot:item.mapped="{ item }">
        <v-icon v-if="item.raw.mapped" color="green" icon="mdi-check"></v-icon>
        <v-icon v-else color="red" icon="mdi-close"></v-icon>
      </template>
      <template v-slot:item.synced="{ item }">
        <v-icon v-if="item.raw.synced" color="green" icon="mdi-check"></v-icon>
        <v-icon v-else color="red" icon="mdi-close"></v-icon>
      </template>
      <template v-slot:item.actions="{ item }">
        <v-btn
          color="primary"
          title="Synchronize"
          variant="tonal"
          class="me-3"
          size="small"
          icon="mdi-sync"
          :disabled="checkStatus(item.raw)"
          @click="save(item.raw.id)"
        ></v-btn>
        <v-btn
          color="primary"
          title="Configure"
          variant="tonal"
          size="small"
          icon="mdi-cog"
          @click="dialogStore.setDialog('MappingDialog', item.raw)"
        ></v-btn>
      </template>
      <template v-slot:expanded-row="{ columns, item }">
        <tr>
          <td :colspan="columns.length">
            <v-table density="compact">
              <tbody>
                <!-- @ts-ignore -->
                <tr v-for="(value, key) in item.raw.product" :key="key">
                  <td>
                    <strong>{{ key }}</strong>
                  </td>
                  <td>{{ value }}</td>
                </tr>
              </tbody>
            </v-table>
          </td>
        </tr>
      </template>
    </v-data-table>
  </v-card>
  <LoadingPage v-if="loading" />
</template>
