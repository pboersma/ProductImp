import { ref } from 'vue'
import { defineStore } from 'pinia'
import { storeMapping } from '@/services/MappingService'

export const useMappingStore = defineStore('mapping', () => {
    const mappings: any = ref([])

    const save = async (product_id: any, mapping: any) => {
        await storeMapping({
            product_id: product_id,
            map: mapping
        })
    }

    return {
        mappings,
        save
    }
})
