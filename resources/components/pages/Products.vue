<script setup lang="ts">
import { ref, reactive, onMounted } from 'vue'
import { VDataTable } from 'vuetify/labs/VDataTable'

// Store
import { useProductStore } from '@/stores/product'

const itemsPerPage = ref(10)
const search = ref('')

const product = useProductStore()
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
    title: '',
    key: 'actions',
    sortable: false
  }
])

const loading = ref(true)

onMounted(async () => {
  await product.fetchAll()
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
      :items="product.products"
      item-value="name"
      :search="search"
      class="elevation-1"
    >
      <template v-slot:item.mapped="{ item }">
        <v-icon color="green" icon="mdi-check"></v-icon>
      </template>
      <template v-slot:item.synced="{ item }">
        <v-icon color="red" icon="mdi-close"></v-icon>
      </template>
      <template v-slot:item.actions="{ item }">
        <v-btn variant="text" size="small" icon="mdi-sync"></v-btn>
        <v-btn variant="text" size="small" icon="mdi-cog"></v-btn>
      </template>
      <template v-slot:expanded-row="{ columns, item }">
        <tr>
          <td :colspan="columns.length">
            <v-table density="compact">
              <tbody>
                <tr
                  v-for="(value, key) in item.raw.product"
                  :key="key"
                  style="background-color: green !important"
                >
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
</template>
