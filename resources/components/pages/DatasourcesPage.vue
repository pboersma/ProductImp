<script setup lang="ts">
import { ref, reactive, onMounted } from 'vue'
import { VDataTableVirtual } from 'vuetify/labs/VDataTable'

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
  }
])

const loading = ref(true)

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
  ></v-data-table-virtual>
</template>
