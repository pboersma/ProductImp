<script setup lang="ts">
import { onMounted } from 'vue'

// Global Components
import Navigation from '@/components/Navigation.vue'

// Pages
import Unauthorized from '@/components/pages/Unauthorized.vue'
import Datasources from '@/components/pages/Datasources.vue'

// Store
import { useNavigationStore } from '@/stores/navigation'

const navigation = useNavigationStore()

// TODO: Strongly type this variable.
const mapTypeComponents: any = {
  Unauthorized: Unauthorized,
  Datasources: Datasources
}

onMounted(async () => {
  await navigation.checkAuthorization()
})
</script>

<template>
  <v-app style="background-color: rgb(255, 255, 255)">
    <Navigation />
    <v-container>
      <component :is="mapTypeComponents[navigation.page]"></component>
    </v-container>
  </v-app>
</template>
