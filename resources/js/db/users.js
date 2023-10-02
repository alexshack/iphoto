export const getByCity = async () => {
    const response = await axios.get(window.workshiftUrls.users.city);
    if (typeof response.data != 'undefined') {
        return response.data;
    }
    return [];
}

export const getActiveManagers = async () => {
    const response = await axios.get(window.workshiftUrls.users.activeManagers);
    console.log({managers: response})
    if (typeof response != 'undefined' && typeof response.data !=' undefined') {
        return response.data;
    }
    return [];
}
