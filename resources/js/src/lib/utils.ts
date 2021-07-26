import Vue from 'vue';

/**
 * Get token bearer
 *
 * @returns {string}
 */
export function getBearer() {
    return 'Bearer ' + Vue.$cookies.get('AUTH_TOKEN');
}

/**
 * Convert object to FormData if it is not yet a FormData
 *
 * @param data
 */
export function convertToFormData(data: object | FormData): FormData {
    if (data instanceof FormData) return data;

    function buildFormData(formData: FormData, data: any, parentKey: string = ''): FormData {
        if (data && typeof data === 'object' && !(data instanceof File)) {
            for (let key of Object.keys(data)) {
                buildFormData(formData, data[key], parentKey ? `${parentKey}[${key}]` : key);
            }
        } else {
            formData.append(parentKey, data);
        }

        return formData;
    }

    return buildFormData(new FormData, data);
}
