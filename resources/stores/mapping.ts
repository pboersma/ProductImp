import { ref } from 'vue'
import { defineStore } from 'pinia'
import { store, getAll } from '@/services/MappingService'

export const useMappingStore = defineStore('mapping', () => {
    const mappings: any = ref([])

    const save = async (product_id: any, mapping: any) => {
        await store({
            product_id: product_id,
            map: mapping
        })
    }

    const fetchAll = async () => {
        const response = await getAll();

        mappings.value = response[0];
    }

    return {
        // State
        mappings,
        // Actions
        save,
        fetchAll
    }
})
