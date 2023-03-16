<script setup lang="ts">
// Store
import { useNavigationStore } from '@/stores/navigation'

const navigation = useNavigationStore()
</script>
<template>
  <v-card
    title="Authorize with WooCommerce"
    text="It looks like ProductImp is not authorized with WooCommerce, You will need to authorize before being able to use ProductImp"
  >
    <v-card-actions>
      <v-btn @click="navigation.authorize">Authorize</v-btn>
    </v-card-actions>
  </v-card>
</template>
