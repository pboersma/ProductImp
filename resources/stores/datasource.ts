import { reactive, type Ref } from 'vue';
import { ref } from 'vue'
import { defineStore } from 'pinia'
import { getDatasources } from '@/services/DatasourceService';

export const useDatasourceStore = defineStore('datasources', () => {
    const datasources: any = ref({})

    const fetchAll = async () => {
        const response = await getDatasources()

        datasources.value = response[0]
    }

    return {
        datasources,
        fetchAll,
    }
})
