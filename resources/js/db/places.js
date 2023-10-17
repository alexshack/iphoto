export const cityPlaces = async (workshiftID = null) => {
    if (!workshiftID) {
        workshiftID = window.workshiftData.id;
    }

    const response = await axios.get(`${window.workshiftUrls.placesList}?workshiftID=${workshiftID}`);
    if (typeof response.data != 'undefined') {
        return response.data;
    }
}