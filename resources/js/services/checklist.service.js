import axiosInstance from "../config/axios.js";


export const loadChecklists = (start, end) => {

    return axiosInstance.get('checklist/', {
        params: {
            start, end
        }
    })
}

export const saveChecklist = (checklist) => {
    return axiosInstance.post('checklist/', checklist);
}

export const updateCheckList = (checklist) => {
    return axiosInstance.put('checklist/', checklist);
}

export const removeChecklist = (id) => {
    return axiosInstance.delete('checklist/', {
        params: {
            id
        }
    })
}
