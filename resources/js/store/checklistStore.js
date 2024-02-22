import {defineStore} from 'pinia'
import {computed, reactive} from "vue";


export const useChecklistStore = defineStore('checklist', () => {
    let checklist = reactive([])
    let selectedItem = reactive({})

    const getSelectedItem = computed(() => selectedItem)
    const getCheckList = computed(() => checklist)

    function addTask(task) {
        checklist.tasks.push(task)
    }

    function setItem(item) {
        selectedItem = item;
    }

    function removeTask(task) {
        checklist.tasks = checklist.tasks.filter(({id}) => task.id !== id)
    }

    function fill(items) {
        checklist = [...items];
    }


    return {checklist, getCheckList, addTask, removeTask, getSelectedItem,setItem, fill}
})
