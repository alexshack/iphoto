export const all = async (workshiftID = null) => {
    if (!workshiftID) {
        workshiftID = window.workshiftData.id;
    }
    const response = await axios.get(`${window.workshiftUrls.visitors.all}?workshiftID=${workshiftID}`)
    if (typeof response.data != 'undefined') {
        return response.data;
    }
    return [];
};

export const update = async (data) => {
    const url = window.workshiftUrls.visitors.update;
    if (typeof data.workshift_id === 'undefined' || !data.workshift_id) {
        data.workshift_id = window.workshiftData.id;
    }
    let response = {
        data: null,
        errors: [],
    };
    try {
        const res = await axios.put(url, data);
        if (res && res.status === 422) {
            for (let p in res.data.errors) {
                for (let i = 0; i < res.data.errors[p].length; i++) {
                    response.errors.push(res.data.errors[p][i]);
                }
            }
        } else if (res && res.data) {
            response.data = res.data;
        }
        return response;
    } catch (err) {
        for (let p in err.response.data.errors) {
            for (let i = 0; i < err.response.data.errors[p].length; i++) {
                response.errors.push(err.response.data.errors[p][i]);
            }
        }
        return response;
    }
}
