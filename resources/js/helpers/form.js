export const prepareFormData = (originalFormData, entity = null) => {
    let formData = {...originalFormData};
    for (let p in formData) {
        if(!formData[p]) {
            continue;
        }
        switch (p) {
            case 'expense_type_id':
            case 'good_id':
            case 'position_id':
            case 'recipient_id':
            case 'sale_type_id':
            case 'status_id':
            case 'user_id':
                if (typeof formData[p].id != 'undefined' && formData[p].id) {
                    formData[p] = formData[p].id;
                }
                break;
            case 'start_time':
            case 'end_time':
            case 'time':
                if (typeof formData[p] != 'undefined') {
                    formData[p] = `${formData[p].hours}:${formData[p].minutes}`;
                }
                break;
            default:
                break;
        }
    }
    return formData;
}
