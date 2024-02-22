import axiosInstance from "../config/axios.js";

/**
 * Permite cargar el listado de los checklists
 * @param start
 * @param end
 * @returns {Promise<axios.AxiosResponse<any>>}
 */
export const loadChecklists = (start, end) => {

    return axiosInstance.get('checklist/', {
        params: {
            start, end
        }
    })
}
/**
 * Permite salvar el checklist seleccionado
 * @param checklist
 * @returns {Promise<axios.AxiosResponse<any>>}
 */
export const saveChecklist = (checklist) => {
    return axiosInstance.post('checklist/', checklist);
}

/**
 * Permite actualizar el checklist seleccionado
 * @param checklist
 * @returns {Promise<axios.AxiosResponse<any>>}
 */
export const updateCheckList = (checklist) => {
    return axiosInstance.put('checklist/', checklist);
}
/**
 * Permite eliminar un checklist seleccionado
 * @param id
 * @returns {Promise<axios.AxiosResponse<any>>}
 */
export const removeChecklist = (id) => {
    return axiosInstance.delete('checklist/', {
        params: {
            id
        }
    })
}
