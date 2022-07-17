<template>
  <div class="container">
    {{ authorized }}
    <!-- <h1 class="text-2xl mb-6 mt-6">
      Product Importer <a v-if="!authorized" :href="authorizeUrl">Authorize</a>
    </h1>
    <div class="bg-white" v-if="authorized">
      <nav class="flex flex-col sm:flex-row">
        <button
          v-on:click="changePage('products')"
          class="tab hover:text-blue-500 focus:outline-none"
          :class="{ active: currentPage === 'products' }"
        >
          Products
        </button>
        <button
          v-on:click="changePage('jobs')"
          class="tab hover:text-blue-500 focus:outline-none"
          :class="{ active: currentPage === 'jobs' }"
        >
          Jobs
        </button>
        <button
          v-on:click="changePage('data-sources')"
          class="tab hover:text-blue-500 focus:outline-none"
          :class="{ active: currentPage === 'data-sources' }"
        >
          Data Sources
        </button>
      </nav>
      <div class="p-5">
        <data-sources v-if="currentPage === 'data-sources'"></data-sources>
        <products v-if="currentPage === 'products'"></products>
        <div v-if="currentPage === 'jobs'">
          <h1>JOBS</h1>
        </div>
      </div>
    </div>
    <div class="bg-white" v-else>
      {{ error }}
    </div> -->
  </div>
</template>
<script setup lang="ts">
import { reactive } from "vue";
import { isAuthorized } from "./Services/AuthService";

const authorized = reactive(isAuthorized);
</script>