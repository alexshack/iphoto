export const ping = async (workshiftID = null) => {
    if (typeof workshiftID === 'undefined' || !workshiftID) {
        workshiftID = window.workshiftData.id;
    }

    const response = await axios.get(`${window.workshiftUrls.ping}?workshiftID=${workshiftID}`)
}
