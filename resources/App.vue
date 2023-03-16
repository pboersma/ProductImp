<script setup lang="ts">
import type { Ref } from 'vue'
import { onMounted, ref } from 'vue'

// Global Components
import Navigation from '@/components/Navigation.vue'

// Pages
import Unauthorized from '@/components/pages/Unauthorized.vue'
import Datasources from '@/components/pages/Datasources.vue'
import Products from '@/components/pages/Products.vue'

// Store
import { useNavigationStore } from '@/stores/navigation'

const loading: Ref<boolean> = ref(true)

const navigation = useNavigationStore()

// TODO: Strongly type this variable.
const mapTypeComponents: any = {
  Unauthorized: Unauthorized,
  Datasources: Datasources,
  Products: Products
}

onMounted(async () => {
  await navigation.checkAuthorization()
  loading.value = false
})
</script>

<template>
  <v-app style="background-color: rgb(255, 255, 255)">
    <Navigation />
    <v-container>
      <component v-if="!loading" :is="mapTypeComponents[navigation.page]"></component>
      <h2 style="text-align: center" v-if="loading">Loading..</h2>
    </v-container>
  </v-app>
</template>
