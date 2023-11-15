export const close = async () => {
    const data = {
        id: window.workshiftData.id,
    };

    const url = window.workshiftUrls.actions.close;

    let response = {
        data: null,
        errors: [],
    };

    try {
        const res = await axios.post(url, data);
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
export const preview = async () => {
    const data = {
        id: window.workshiftData.id,
    };

    const url = window.workshiftUrls.actions.preview;

    let response = {
        data: null,
        errors: [],
    };

    try {
        const res = await axios.post(url, data);
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


export const reopen = async () => {
    const data = {
        id: window.workshiftData.id,
    };

    const url = window.workshiftUrls.actions.reopen;

    let response = {
        data: null,
        errors: [],
    };

    try {
        const res = await axios.post(url, data);
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
