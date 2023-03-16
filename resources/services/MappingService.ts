import type { AxiosResponse } from 'axios'
import axios from "axios";

// TODO: Move to Interface Files?
interface AxiosCustomResponse extends AxiosResponse {
    data: AxiosCustomResponseData
}

interface AxiosCustomResponseData {
    status: number
}

export const getMappings = async (): Promise<any> => {
    return await axios.get(`/productimp/v1/mappings`)
        .then((response: AxiosCustomResponse) => {
            return response.data;
        })
        .catch(error => {
            throw error
        });
};

export const storeMapping = async (payload: any): Promise<any> => {
    return await axios.post(`/productimp/v1/mapping`, payload)
        .then((response: AxiosCustomResponse) => {
            return response.data;
        })
        .catch(error => {
            throw error
        });
};