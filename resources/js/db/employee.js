export const all = async (workshiftID = null) => {
    if (!workshiftID) {
        workshiftID = window.workshiftData.id;
    }
    const response = await axios.get(`${window.workshiftUrls.employee.all}?workshiftID=${workshiftID}`)
    if (typeof response.data != 'undefined') {
        return response.data;
    }
    return [];
};

export const deleteEmployee = async (ID) => {
    const url = window.workshiftUrls.employee.delete.replace('%s', ID);
    const response = await axios.delete(url, {});
    if (typeof response.data != 'undefined') {
        return response.data;
    }
    return null;
}

export const getEmployee = async (ID) => {
    const url = window.workshiftUrls.employee.show.replace('%s', ID);
    const response = await axios.get(url);
    if (typeof response.data != 'undefined') {
        return response.data;
    }
    return null;
}

export const getPositions = async () => {
    const response = await axios.get(`${window.workshiftUrls.employee.positions}`);
    if (typeof response.data != 'undefined') {
        return response.data;
    }
    return [];
}

export const getStatuses = async () => {
    const response = await axios.get(`${window.workshiftUrls.employee.statuses}`);
    if (typeof response.data != 'undefined') {
        return response.data;
    }
    return [];
};

export const store = async (data) => {
    const url = window.workshiftUrls.employee.store;
    if (typeof data.workshift_id === 'undefined' || data.workshift_id) {
        data.workshift_id = window.workshiftData.id;
    }
    let response = {
        data: null,
        errors: [],
    };
    try {
        const res = await axios.post(url, data);
        if (res.data) {
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
};

export const updateEmployee = async (data) => {
    const url = window.workshiftUrls.employee.update.replace('%s', data.id);
    let response = {
        data: null,
        errors: [],
    };
    try {
        const res = await axios.put(url, data);
        if (res.data) {
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
