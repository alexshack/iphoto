export const all = async (workshiftID = null) => {
    if (!workshiftID) {
        workshiftID = window.workshiftData.id;
    }
    const response = await axios.get(`${window.workshiftUrls.fcds.all}?workshiftID=${workshiftID}`)
    if (typeof response.data != 'undefined') {
        return response.data;
    }
    return [];
};

export const deleteFCD = async (ID) => {
    const url = window.workshiftUrls.fcds.delete.replace('%s', ID);
    const response = await axios.delete(url, {});
    if (typeof response.data != 'undefined') {
        return response.data;
    }
    return null;
}

export const getFCD = async (ID) => {
    const url = window.workshiftUrls.fcds.show.replace('%s', ID);
    const response = await axios.get(url);
    if (typeof response.data != 'undefined') {
        return response.data;
    }
    return null;
}

export const store = async (data) => {
    const url = window.workshiftUrls.fcds.store;
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

export const updateFCD = async (data) => {
    const url = window.workshiftUrls.fcds.update.replace('%s', data.id);
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
