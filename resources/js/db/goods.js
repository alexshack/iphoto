export const all = async (type = 'general') => {
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

    const response = await axios.get(`${window.workshiftUrls.goodsList}?type=${typeID}`)
    if (typeof response.data != 'undefined') {
        return response.data;
    }
    return [];
};


