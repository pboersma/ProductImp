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
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
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
          <div class="flex justify-between w-full">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
              Map Product
            </h3>
            <button
              @click="createEmptyMapping()"
              class="
                px-4
                py-2
                outline-none
                border-2 border-blue-400
                rounded
                text-blue-500
                font-medium
                active:scale-95
                hover:bg-blue-600 hover:text-white hover:border-transparent
                focus:bg-blue-600
                focus:text-white
                focus:border-transparent
                focus:ring-2
                focus:ring-blue-600
                focus:ring-offset-2
                disabled:bg-gray-400/80
                disabled:shadow-none
                disabled:cursor-not-allowed
                transition-colors
                duration-200
              "
            >
              <font-awesome-icon icon="fa-solid fa-plus" />
              Add Mapping
            </button>
          </div>
        </div>
        <!-- Modal body -->
        <div class="p-1 space-y-6 h-96" style="overflow-y: auto">
          <table class="text-sm text-left text-gray-500 dark:text-gray-400">
            <tbody>
              <MappingRow
                v-for="mapping in mappings"
                v-bind:key="mapping.id"
                :mapping-data="mapping"
                @mapping-row-saved="setMapping"
                @mapping-row-removed="removeMapping"
              ></MappingRow>

              <tr v-if="!mappings.length">
                <td
                  class="
                    px-6
                    py-4
                    font-medium
                    text-gray-900
                    dark:text-white
                    whitespace-nowrap
                  "
                >
                  No Mappings configured yet.
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
            @click="saveProductMap"
            type="button"
            class="
              text-white
              bg-blue-700
              hover:bg-blue-800
              focus:ring-4 focus:outline-none focus:ring-blue-300
              font-medium
              rounded-lg
              text-sm
              px-5
              py-2.5
              text-center
              dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800
            "
          >
            Save
          </button>
          <button
            data-modal-toggle="defaultModal"
            @click="$emit('closeProductMapModal')"
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
            Cancel
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
import { ref, defineProps, defineEmits } from 'vue';
import { v4 as uuidv4 } from 'uuid';
import { saveMap } from '@/services/ProductService';
import MappingRow from './Mapping/MappingRow.vue';

const emit = defineEmits(['closeProductMapModal']);

const props = defineProps({
  visible: Boolean,
  // TODO: Strongly type this prop.
  currentProduct: Object,
});

const mappings: any = ref(props.currentProduct.map ?? []);

const setMapping = (e: any) => {
  const foundIndex = mappings.value.findIndex(
    (mapping: any) => mapping.id === e.value.id,
  );

  mappings.value[foundIndex] = e.value;
};

const removeMapping = (e: any) => {
  const foundIndex = mappings.value.findIndex(
    (mapping: any) => mapping.id === e.value.id,
  );

  if (foundIndex > -1) {
    mappings.value.splice(foundIndex, 1);
  }
};

const createEmptyMapping = () => {
  mappings.value.push({ id: uuidv4() });
};

const saveProductMap = () => {
  saveMap(props.currentProduct.id, mappings.value);
  emit('closeProductMapModal');
};
</script>

  <style lang="less">
.bgblackopacitied {
  background-color: rgba(0, 0, 0, 0.4);
}
</style>
