export const all = async (workshiftID = null) => {
    if (!workshiftID) {
        workshiftID = window.workshiftData.id;
    }
    const response = await axios.get(`${window.workshiftUrls.calcs.all}?workshiftID=${workshiftID}`)
    if (typeof response.data != 'undefined') {
        return response.data;
    }
    return [];
};
