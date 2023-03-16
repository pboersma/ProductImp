<script setup lang="ts">
import { ref } from 'vue'
import { isEmpty, size } from 'lodash';
import MappingRow from './MappingRow.vue'
import { v4 as uuidv4 } from 'uuid'
import { useDialogStore } from '@/stores/dialog'
import { useMappingStore } from '@/stores/mapping'

const dialogStore = useDialogStore()
const mappingStore = useMappingStore()

const productName = ref(dialogStore.dialogData.name)
const mappings: any = ref(dialogStore.dialogData.mapping ?? [])

const createEmptyMapping = () => {
  mappings.value.push({ id: uuidv4() })
}

const removeMapping = (e: any) => {
  const foundIndex = mappings.value.findIndex((mapping: any) => mapping.id === e.value.id)
  if (foundIndex > -1) {
    mappings.value.splice(foundIndex, 1)
  }
}

const setMapping = (e: any) => {
  const foundIndex = mappings.value.findIndex((mapping: any) => mapping.id === e.value.id)
  mappings.value[foundIndex] = e.value
}

const saveProductMap = () => {
  // Filter out empty pairing
  const mappingsFinal = mappings.value.filter(mapping => {
    if(size(mapping) > 1) {
      return !isEmpty(mapping)
    }
  })

  mappingStore.save(mappingsFinal)
};
</script>
<template>
  <v-dialog v-model="dialogStore.isDialogOpen" persistent width="40%">
    <v-card>
      <template v-slot:title>Mapping</template>
      <template v-slot:subtitle>{{ productName }}</template>
      <v-card-text>
        <v-table>
          <thead>
            <tr>
              <th class="text-left"><strong>Product Field</strong></th>
              <th class="text-center"><v-icon icon="mdi-arrow-right"></v-icon></th>
              <th class="text-left"><strong>WooCommerce Field</strong></th>
              <th class="text-right">
                <v-btn
                  @click="createEmptyMapping()"
                  color="primary"
                  variant="text"
                  prepend-icon="mdi-plus"
                >
                  Add Mapping
                </v-btn>
              </th>
            </tr>
          </thead>
          <tbody>
            <MappingRow
              v-for="mapping in mappings"
              v-bind:key="mapping.id"
              :mapping-data="mapping"
              @mapping-row-saved="setMapping"
              @mapping-row-removed="removeMapping"
            ></MappingRow>
            <tr v-if="!mappings.length">
              <td>No Mappings configured yet.</td>
            </tr>
          </tbody>
        </v-table>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="primary" @click="saveProductMap()">Save</v-btn>
        <v-btn color="primary" @click="dialogStore.closeDialog()">Cancel</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
