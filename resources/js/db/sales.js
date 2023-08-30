export const all = async (workshiftID = null, type = 'general') => {
    if (!workshiftID) {
        workshiftID = window.workshiftData.id;
    }

    const types = {
        general: 1,
        individual: 2,
        tmc: 3,
        consumables: 4,
        workingout: 5,
    };

    let typeID = 1;

    if (typeof types[type] != 'undefined') {
        typeID = types[type];
    }

    const response = await axios.get(`${window.workshiftUrls.sale.all}?workshiftID=${workshiftID}&type=${typeID}`)
    if (typeof response.data != 'undefined') {
        return response.data;
    }
    return [];
};

export const deleteSale = async (ID) => {
    const url = window.workshiftUrls.sale.delete.replace('%s', ID);
    const response = await axios.delete(url, {});
    if (typeof response.data != 'undefined') {
        return response.data;
    }
    return null;
}

export const getSale = async (ID) => {
    const url = window.workshiftUrls.sale.show.replace('%s', ID);
    const response = await axios.get(url);
    if (typeof response.data != 'undefined') {
        return response.data;
    }
    return null;
}

export const store = async (data) => {
    const url = window.workshiftUrls.sale.store;
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

export const updateSale = async (data) => {
    const url = window.workshiftUrls.sale.update.replace('%s', data.id);
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
