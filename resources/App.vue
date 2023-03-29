<script setup lang="ts">
import type { Ref } from 'vue'
import { onMounted, ref } from 'vue'

// Global Components
import Navigation from '@/components/NavigationBar.vue'

// Pages
import UnauthorizedPage from '@/components/pages/UnauthorizedPage.vue'
import DatasourcesPage from '@/components/pages/DatasourcesPage.vue'
import ProductsPage from '@/components/pages/ProductsPage.vue'

import MappingDialog from '@/components/dialogs/MappingDialog.vue'

// Store
import { useNavigationStore } from '@/stores/navigation'
import { useDialogStore } from '@/stores/dialog'

const loading: Ref<boolean> = ref(true)

const navigationStore = useNavigationStore()
const dialogStore = useDialogStore()

// TODO: Strongly type this variable.
const mapPageComponents: any = {
  UnauthorizedPage: UnauthorizedPage,
  DatasourcesPage: DatasourcesPage,
  ProductsPage: ProductsPage
}

const mapDialogComponents: any = {
  MappingDialog: MappingDialog
}

onMounted(async () => {
  await navigationStore.checkAuthorization()
  loading.value = false
})
</script>

<template>
  <v-app>
    <Navigation />
    <v-container>
      <component v-if="!loading" :is="mapPageComponents[navigationStore.page]"></component>
      <component v-if="!loading" :is="mapDialogComponents[dialogStore.currentDialog]"></component>
      <div style="text-align: center;" v-if="loading">
        <img style="height: 3em;" src="https://media.tenor.com/On7kvXhzml4AAAAj/loading-gif.gif" />
      </div>
    </v-container>
  </v-app>
</template>
<style lang="scss">
@use 'vuetify/styles';
@import 'https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css';
</style>