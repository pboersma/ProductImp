<template>
<div v-show="!loading">
  <NavigationBar/>
  <PageSelect />
</div>
</template>

<script setup lang="ts">
import { computed, onMounted, ref } from 'vue';
import store from './store';
import NavigationBar from './components/NavigationBar.vue';
import PageSelect from './components/PageSelect.vue';

const loading = ref(true);

/**
 * Computed Properties
 */
const authorized = computed(() => store.getters['authorization/isAuthorized']);

onMounted(() => {
  const promises = [store.dispatch('authorization/authorized')];

  Promise.all(promises).then(() => {
    loading.value = false;

    Promise.resolve();
  });
});
</script>
