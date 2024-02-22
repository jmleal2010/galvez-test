import {defineStore} from 'pinia'
import {computed, reactive} from "vue";

/**
 * Permite manejar el estado de los checklist a lo largo de la aplicacion
 * @type {StoreDefinition<"checklist", _ExtractStateFromSetupStore<{removeTask: function(*): void, checklist: [], getCheckList: ComputedRef<Array<UnwrapRefSimple<*>>>, fill: function(*): void, getSelectedItem: ComputedRef<UnwrapNestedRefs<{}>>, setItem: function(*): void, addTask: function(*): void}>, _ExtractGettersFromSetupStore<{removeTask: function(*): void, checklist: [], getCheckList: ComputedRef<Array<UnwrapRefSimple<*>>>, fill: function(*): void, getSelectedItem: ComputedRef<UnwrapNestedRefs<{}>>, setItem: function(*): void, addTask: function(*): void}>, _ExtractActionsFromSetupStore<{removeTask: function(*): void, checklist: [], getCheckList: ComputedRef<Array<UnwrapRefSimple<*>>>, fill: function(*): void, getSelectedItem: ComputedRef<UnwrapNestedRefs<{}>>, setItem: function(*): void, addTask: function(*): void}>>}
 */

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
