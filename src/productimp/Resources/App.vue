<template>
  <div class="container">
    <h1 class="text-2xl mb-6 mt-6">Product Importer <a v-if="!authorized" href="https://lycan-media.nl/wp-json/productimp/v1/gatekeeper/generate">Authorize</a></h1>
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
    </div>
  </div>
</template>
<script>
import axios from 'axios';
import DataSources from "./Pages/DataSources.vue";
import Products from "./Pages/Products.vue";

export default {
  components: {
    DataSources,
    Products
  },
  data() {
    return {
      currentPage: "products",
      authorized: false,
      error: null
    };
  },
  methods: {
    changePage(page) {
      this.currentPage = page;
    },
  },
  mounted() {
    const self = this;
    console.log(window.location.href)
    axios.get("https://lycan-media.nl/wp-json/productimp/v1/gatekeeper/authorized")
      .then(response => {
        if(response.data.status === 401) {
          this.error = response.data.message;
          return;
        }

        this.authorized = true;
      })
      .catch(error => {
        console.log(error);
      });
  }
};
</script>
