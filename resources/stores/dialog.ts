import { ref } from 'vue'
import { defineStore } from 'pinia'

export const useDialogStore = defineStore('dialog', () => {
    const currentDialog = ref('')
    const dialogData = ref({})
    const isDialogOpen = ref(false)

    const setDialog = async (dialog: any, data: any) => {
        currentDialog.value = dialog
        dialogData.value = data
        isDialogOpen.value = true;
    }

    const closeDialog = async () => {
        isDialogOpen.value = false
        currentDialog.value = ''
        dialogData.value = {}
    }

    return {
        currentDialog,
        dialogData,
        setDialog,
        isDialogOpen,
        closeDialog
    }
})
