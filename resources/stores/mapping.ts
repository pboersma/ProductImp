import { ref } from 'vue'
import { defineStore } from 'pinia'

export const useMappingStore = defineStore('mapping', () => {
    const mappings: any = ref([])

    const fetchAll = async () => {
        mappings.value = [
            {
                test: "123"
            }
        ]
    }

    const save = async mapping => {
        console.log(
            {
                id: 1,
                mapping: mapping
            }
        )
    }

    return {
        mappings,
        fetchAll,
        save
    }
})
