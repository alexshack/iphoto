export const getByCity = async () => {
    const response = await axios.get(window.workshiftUrls.users.city);
    if (typeof response.data != 'undefined') {
        return response.data;
    }
    return [];
}
