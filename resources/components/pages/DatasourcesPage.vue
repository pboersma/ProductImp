<script setup lang="ts">
// @ts-nocheck
import { ref, reactive, onMounted } from 'vue'
import { VDataTableVirtual } from 'vuetify/labs/VDataTable'
import Swal from 'sweetalert2'

import LoadingPage from '@/components/pages/LoadingPage.vue'

// Store
import { useDatasourceStore } from '@/stores/datasource'

const datasource = useDatasourceStore()

const headers = reactive([
  {
    title: 'Name',
    key: 'datasource_name'
  },
  {
    title: 'Url',
    key: 'datasource_url'
  },
  {
    title: 'Actions',
    key: 'actions',
    sortable: false
  }
])

const loading = ref(true)

const sync = async (id: any) => {
  await Swal.fire({
  title: 'Do you want to sync this datasource?',
  showCancelButton: true,
  confirmButtonText: 'Yes, sync it!',
}).then(async (result) => {
  /* Read more about isConfirmed, isDenied below */
  if (result.isConfirmed) {
    await datasource.sync(id)
    await Swal.fire('Synced!', '', 'success')
  }
})
 
}

onMounted(async () => {
  await datasource.fetchAll()
  loading.value = false
})
</script>
<template>
  <v-data-table-virtual
    v-if="!loading"
    dense
    :headers="headers"
    :items="datasource.datasources"
    item-value="name"
    class="elevation-1"
  >
  <template v-slot:item.actions="{ item }">
        <v-btn
          color="primary"
          title="Synchronize"
          variant="tonal"
          class="me-3"
          size="small"
          icon="mdi-sync"
          @click="sync(item.raw.id)"
        ></v-btn>
      </template>
</v-data-table-virtual>
  <LoadingPage v-if="loading" />
</template>
