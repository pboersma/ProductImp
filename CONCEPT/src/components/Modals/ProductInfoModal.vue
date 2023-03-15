<!-- eslint-disable camelcase -->
<!-- eslint-disable camelcase -->
<!-- eslint-disable vuejs-accessibility/label-has-for -->
<template>
  <div
    id="sync-data-modal"
    tabindex="-1"
    aria-hidden="true"
    :class="{ hidden: !visible }"
    class="
      bgblackopacitied
      fixed
      z-50
      top-0
      pt-20
      w-full
      h-full
    "
  >
    <div class="mx-auto p-4 w-full max-w-2xl h-full md:h-auto">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <!-- Modal header -->
        <div
          class="
            flex
            justify-between
            items-start
            p-4
            rounded-t
            border-b
            dark:border-gray-600
          "
        >
          <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
            Product Information
          </h3>
          <button
            type="button"
            @click="$emit('closeProductInfoModal')"
            class="
              text-gray-400
              bg-transparent
              hover:bg-gray-200 hover:text-gray-900
              rounded-lg
              text-sm
              p-1.5
              ml-auto
              inline-flex
              items-center
              dark:hover:bg-gray-600 dark:hover:text-white
            "
            data-modal-toggle="syncDataSourceModal"
          >
            x
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <!-- Modal body -->
        <div class="p-1 space-y-6 h-96" style="overflow-y: auto">
          <table class="text-sm text-left text-gray-500 dark:text-gray-400">
            <tbody>
              <tr
                v-for="(value, name) in currentProduct"
                :key="name"
                class="
                  bg-white
                  border-b
                  dark:bg-gray-800 dark:border-gray-700
                  hover:bg-gray-50
                  dark:hover:bg-gray-600
                "
              >
                <td
                  class="
                    px-6
                    py-4
                    font-medium
                    text-gray-900
                    dark:text-white
                    whitespace-nowrap
                  "
                  style="width: 1%"
                >
                  {{ name }}
                </td>
                <td class="px-6 py-4">
                  {{ value }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- Modal footer -->
        <div
          class="
            flex
            items-center
            p-6
            space-x-2
            rounded-b
            border-t border-gray-200
            dark:border-gray-600
          "
        >
          <button
            data-modal-toggle="defaultModal"
            @click="$emit('closeProductInfoModal')"
            type="button"
            class="
              text-gray-500
              bg-white
              hover:bg-gray-100
              focus:ring-4 focus:outline-none focus:ring-blue-300
              rounded-lg
              border border-gray-200
              text-sm
              font-medium
              px-5
              py-2.5
              hover:text-gray-900
              focus:z-10
              dark:bg-gray-700
              dark:text-gray-300
              dark:border-gray-500
              dark:hover:text-white
              dark:hover:bg-gray-600
              dark:focus:ring-gray-600
            "
          >
            Close
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
import { ref, defineProps, defineEmits } from 'vue';

const emit = defineEmits(['closeProductInfoModal']);

const props = defineProps({
  visible: Boolean,
  currentProduct: String,
});

const modalActive = ref(false);

const isSyncing = ref(false);
</script>

<style lang="less">
.bgblackopacitied {
  background-color: rgba(0, 0, 0, 0.4);
}
</style>
