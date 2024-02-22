<script setup>
import {onMounted, reactive, ref} from 'vue'
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
import multiMonthPlugin from '@fullcalendar/multimonth'
import moment from "moment";
import {loadChecklists, removeChecklist, saveChecklist, updateCheckList} from "../../services/checklist.service.js";
import {useChecklistStore} from "../../store/checklistStore.js";
import {CheckIcon, PlusCircleIcon, XCircleIcon, XMarkIcon} from "@heroicons/vue/24/solid/index.js";
import ConfirmDialog from "./ConfirmDialog.vue";
import Error from "./Error.vue";

const calendarOptions = reactive({
    plugins: [
        dayGridPlugin,
        timeGridPlugin,
        interactionPlugin,
        multiMonthPlugin
    ],
    initialView: 'dayGridMonth',
    initialEvents: [], // alternatively, use the `events` setting to fetch from a feed
    editable: true,
    selectable: true,
    selectMirror: true,
    dayMaxEvents: true,
    weekends: true,
    events: [],
    select: handleDateSelect,
    eventsSet: handleEvents,
})

const currentEvents = ref([])
const createNewCheckList = ref(false);
const newTask = ref('')
const showNewTask = ref(false);
const isValidTitle = ref(true);
const isValidDate = ref(true);
const isValidTask = ref(true);
const openConfirmDialog = ref(false)
let errors = ref([]);
let list = reactive([])


let selectedItem = reactive({
    id: '',
    name: '',
    description: '',
    date: '',
    tasks: []
});
const checklistStore = useChecklistStore();

function handleEvents(events) {
    currentEvents.value = events
}

function getItemByDate(initialDate) {

    const item = list.find(({date}) => date === initialDate)

    if (item) {
        selectedItem.id = item.id
        selectedItem.title = item.title
        selectedItem.date = item.date;
        selectedItem.description = item.description
        selectedItem.tasks = item.tasks

    } else {
        selectedItem.title = ''
        selectedItem.date = initialDate;
        selectedItem.description = ''
        selectedItem.tasks = []
    }

}

function handleDateSelect(selectInfo) {

    let calendarApi = selectInfo.view.calendar
    getItemByDate(selectInfo.startStr)

    if (selectedItem.title === '') createNewCheckList.value = false

    calendarApi.unselect()
}

function addNewTask(e) {
    e.preventDefault()

    if (!newTask.value) {
        isValidTask.value = false
    } else {
        const newItem = {
            title: newTask.value,
            active: false,
            removed: false
        }

        selectedItem.tasks = [...selectedItem.tasks, newItem]
        showNewTask.value = false
        newTask.value = ''
    }

}

function toggleActive(index) {
    selectedItem.tasks[index].active = !selectedItem.tasks[index].active
}

function removeTask(index) {
    selectedItem.tasks[index].removed = true
}

function hideNewTaskInput() {
    showNewTask.value = false
    newTask.value = ''
    isValidTask.value = true;
}

function deleteChecklist() {
    removeChecklist(selectedItem.id).then(({status}) => {
        if (status === 200) {
            load()
            eraseForm();
            openConfirmDialog.value = false;
        }
    })
}

const validateForm = () => {
    isValidTitle.value = !!selectedItem.title.trim();
    isValidDate.value = /^\d{4}-\d{2}-\d{2}$/.test(selectedItem.date);

    if (isValidTitle) selectedItem.name = selectedItem.title
    return isValidTitle.value && isValidDate.value && isValidTask.value;


};

function eraseForm() {
    selectedItem.id = ''
    selectedItem.title = ''
    selectedItem.date = moment().format('YYYY-MM-DD');
    selectedItem.description = ''
    selectedItem.tasks = []
    errors.value = [];
}

function save() {
    if (validateForm()) {
        if (!selectedItem.id) saveChecklist(selectedItem)
            .then(({data: {id, date, name: title}, status}) => {
                if (status === 201) {
                    load()
                    eraseForm();
                }
            })
            .catch(({response}) => {
                const {data, status} = response

                if (data && data.errors) {
                    const arraysOfErrors = Object.values(data.errors);
                    errors.value = arraysOfErrors.flat();
                }
            })
        else {
            updateCheckList(selectedItem)
                .then(({data: {id, date, name: title}, status}) => {
                if (status === 200) {
                    load()
                    eraseForm();
                }
            })
                .catch(({response}) => {
                const {data, status} = response

                if (data && data.errors) {
                    const arraysOfErrors = Object.values(data.errors);
                    errors.value = arraysOfErrors.flat();
                }
            })
        }
    }
}

async function load() {
    const startDate = moment().startOf('month').format('YYY-MM-DD')
    const endDate = moment().endOf('month').format('YYY-MM-DD')
    const {data} = await loadChecklists(startDate, endDate)

    list = data;
    checklistStore.fill(data)

    getItemByDate(moment().format('YYYY-MM-DD'))
    calendarOptions.events = data;
}

onMounted(async () => {
    load();
})


</script>

<template>
    <Error v-if="errors.length" :errors="errors"/>
    <div class="grid grid-cols-12 gap-2">
        <div class="col-span-12 lg:col-span-8">
            <FullCalendar
                :options='calendarOptions'
                class='demo-app-calendar'
            >
                <template v-slot:eventContent='arg'>
                    <b>{{ arg.timeText }}</b>
                    <i>{{ arg.event.title }}</i>
                </template>
            </FullCalendar>
        </div>
        <div class="col-span-12 lg:col-span-4 ">
            <form @submit.prevent="save">
                <div v-if="createNewCheckList || selectedItem.title "
                     class="space-y-12 px-2 md:py-0">
                    <div class="border-b border-gray-900/10 pb-2">
                        <h2 class="text-base font-semibold leading-7 text-gray-900">Información checklist</h2>

                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8">
                            <div class="sm:col-span-4">
                                <label class="block text-sm font-medium leading-6 text-gray-900"
                                       for="title">Título</label>
                                <div class="mt-2">
                                    <input id="title" v-model="selectedItem.title"
                                           :class="!isValidTitle ? 'border border-red-500 ring-inset ring-red-500 focus:ring-2 focus:ring-inset focus:ring-red-600 ':  ''"
                                           autocomplete="gtitle"
                                           class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                           name="title"
                                           type="text"
                                           @input="isValidTitle=true"/>
                                    <span v-if="!isValidTitle"
                                          class="text-xs text-red-500">El título es obligatorio.</span>
                                </div>
                            </div>

                            <div class="sm:col-span-4 ">
                                <label class="block  text-sm font-medium leading-6 text-gray-900" for="description">Descripción
                                </label>
                                <div class="mt-2">
                                    <textarea id="description" v-model="selectedItem.description"
                                              autocomplete="email"
                                              class="overflow-hidden resize-none px-2 lock w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                              name="description"
                                              rows="4"/>
                                </div>
                            </div>

                            <div class="sm:col-span-1">
                                <label class="block text-sm font-medium leading-6 text-gray-900"
                                       for="date">Fecha</label>
                                <div class="mt-2">
                                    <input id="date" v-model="selectedItem.date" autocomplete="address-level1"
                                           class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                           disabled
                                           name="date"
                                           type="text"/>
                                    <span v-if="!isValidDate">La fecha debe estar en formato YYYY-MM-DD.</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-between items-end mt-4">
                            <h2 class="text-base font-semibold leading-7 text-gray-900">Tareas</h2>
                            <div class="w-6" @click="showNewTask = true">
                                <PlusCircleIcon class="cursor-pointer"/>
                            </div>
                        </div>
                        <div v-if="selectedItem" class="mt-4 space-y-2">
                            <div v-if="showNewTask" class="flex flex-col gap-2">
                                <div class="flex gap-2">
                                    <input id="newtask" v-model="newTask"
                                           :class="!isValidTask ? 'border border-red-500 ring-inset ring-red-500 focus:ring-2 focus:ring-inset focus:ring-red-600 ':  ''"
                                           autocomplete="new-task"
                                           class="px-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                           name="newtask"
                                           placeholder="Nueva tarea"
                                           type="text"
                                           @input="isValidTask = true"/>


                                    <button
                                        class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                        @click="addNewTask">
                                        <CheckIcon class="w-4"/>
                                    </button>
                                    <button
                                        class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600"
                                        @click="hideNewTaskInput">
                                        <XMarkIcon class="w-4"/>
                                    </button>
                                </div>
                                <span v-if="!isValidTask" class="text-xs text-red-500 ">El nombre de la tarea es obligatorio.</span>
                            </div>
                            <div class=" h-40 overflow-y-auto">
                                <div v-for="(task, index) in selectedItem.tasks" :key="index"
                                     class="shadow-md px-2 rounded-md border border-gray-200 py-2 flex flex-row justify-between items-center">
                                    <div>
                                        <div class="relative flex gap-x-3">
                                            <div class="flex h-6 items-center">
                                                <input :id="`comments_${index}`" :checked="task.active"
                                                       :disabled="task.removed"
                                                       class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"
                                                       name="comments"
                                                       type="checkbox"
                                                       @change="toggleActive(index)"/>
                                            </div>
                                            <div class="text-sm leading-6">
                                                <label :class="task.removed?'line-through': ''"
                                                       :for="`comments_${index}`"
                                                       class="font-medium text-gray-900 cursor-pointer"
                                                >{{ task.title }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <XCircleIcon class="text-red-300 cursor-pointer w-6" @click="removeTask(index)"/>
                                </div>
                            </div>

                        </div>
                        <div class="mt-6 flex items-center justify-end gap-x-6">
                            <button @click="createNewCheckList = false" class="text-sm font-semibold leading-6 text-gray-900" type="button">Cancelar
                            </button>
                            <button
                                :disabled="!validateForm"
                                class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                type="submit">
                                Guardar
                            </button>

                            <button
                                v-if="selectedItem.id"
                                :disabled="!validateForm"
                                class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600"
                                type="button"
                                @click="openConfirmDialog = true">
                                Eliminar
                            </button>
                        </div>
                    </div>


                </div>
                <div v-else class="mt-60 cursor-pointer text-center" @click="createNewCheckList = true">
                    <span class="h1 font-bold">No hay checklist para este día.. desea crear uno?</span>
                    <PlusCircleIcon class="w-20 mx-auto"/>
                </div>
            </form>
        </div>
        <ConfirmDialog v-if="openConfirmDialog" :opened="openConfirmDialog" @close="openConfirmDialog = false"
                       @delete="deleteChecklist"/>
    </div>
</template>

<style lang='css' scoped>

h2 {
    margin: 0;
    font-size: 16px;
}

ul {
    margin: 0;
    padding: 0 0 0 1.5em;
}

li {
    margin: 1.5em 0;
    padding: 0;
}

b { /* used for event dates/times */
    margin-right: 3px;
}

.demo-app {
    display: flex;
    min-height: 100%;
    font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
    font-size: 14px;
}

.demo-app-sidebar {
    width: 300px;
    line-height: 1.5;
    background: #eaf9ff;
    border-right: 1px solid #d3e2e8;
}

.demo-app-sidebar-section {
    padding: 2em;
}

.demo-app-main {
    flex-grow: 1;
    padding: 3em;
}

.fc { /* the calendar root */
    max-width: 1100px;
    margin: 0 auto;
}

</style>
