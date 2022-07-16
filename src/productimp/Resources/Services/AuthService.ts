import axios, { AxiosResponse } from "axios";

// TODO: Move to Interface Files?
interface AxiosCustomResponse extends AxiosResponse {
    data: AxiosCustomResponseData
}

interface AxiosCustomResponseData {
    status: number
}

export const isAuthorized = async (): Promise<boolean> => {
    return await axios.get(`${window.location.origin}/wp-json/productimp/v1/gatekeeper/authorized`)
        .then((response: AxiosCustomResponse) => {
            if (response.data.status === 401) {
                return false
            }

            return true
        })
        .catch(error => {
            throw error
        });
};