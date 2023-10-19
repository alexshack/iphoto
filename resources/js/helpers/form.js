import {getData} from '@/helpers/proxy.js';

const filterForMultiSelect = (ids, arr = []) => {
    arr = getData(arr);
    let result = [];
    for (let p in arr) {
        console.log(p, arr[p].id)
        if (typeof arr[p].id !== 'undefined' && ids.includes(arr[p].id)) {
            result.push(arr[p]);
        }
    }
    return result;
}

const filterForSelect = (id, arr = []) => {
    return arr.filter(item => {
        if (typeof item.id !== 'undefined' && item.id === id) {
            return true;
        }
        return false;
    })
};

export const prepareData = (originalFormData, db = {}) => {
    let formData = {...originalFormData};

    for (let p in formData) {
        if (!formData[p]) {
            continue;
        }

        switch (p) {
            case 'start_time':
            case 'end_time':
            case 'time':
                const timeArr = formData[p].split(':');
                formData[p] = {
                    hours: timeArr[0],
                    minutes: timeArr[1],
                };
                break;
            case 'user_id':
                if (typeof db.users != 'undefined') {
                    const f = filterForSelect(formData[p], db.users);
                    console.log({
                        users: db.users,
                        f1: formData[p],
                        f,
                    });
                    if (f.length > 0) {
                        formData[p] = f[0];
                    }
                }
                break;
            case 'status_id':
                if (typeof db.statuses != 'undefined') {
                    const f = filterForSelect(formData[p], db.statuses);
                    if (f.length > 0) {
                        formData[p] = f[0];
                    }
                }
                break;
            case 'position_id':
                if (typeof db.positions != 'undefined') {
                    const f = filterForSelect(formData[p], db.positions);
                    if (f.length > 0) {
                        formData[p] = f[0];
                    }
                }
                break;
            case 'good_id':
                if (typeof db.goods != 'undefined') {
                    const f = filterForSelect(formData[p], db.goods);
                    if (f.length > 0) {
                        formData[p] = f[0];
                    }
                }
                break;
            case 'employees':
                if (typeof db.employees != 'undefined') {
                    const ids = formData[p].map(item => {
                        return item.employee_id;
                    });
                    const f = filterForMultiSelect(ids, db.employees);
                    if (f.length > 0) {
                        formData[p] = f[0];
                    }
                }
                break;
            case 'employee_id':
                if (typeof db.employees != 'undefined') {
                    const f = filterForSelect(formData[p], db.employees);
                    if (f.length > 0) {
                        formData[p] = f[0];
                    }
                }
                break;
            case 'expense_type_id':
                if (typeof db.expenseTypes != 'undefined') {
                    const f = filterForSelect(formData[p], db.expenseTypes);
                    if (f.length > 0) {
                        formData[p] = f[0];
                    }
                }
                break;
            case 'recipient_id':
                if (typeof formData['recipient_type'] !== 'undefined') {
                    const dbLib = formData['recipient_type'] === 'place' ? db.places : db.managers;
                    const f = filterForSelect(formData[p], dbLib);
                    if (f.length > 0) {
                        formData[p] = f[0];
                    }
                }
                break;
            case 'place_id':
                if (typeof db.places != 'undefined') {
                    const f = filterForSelect(formData[p], db.places);
                    if (f.length > 0) {
                        formData[p] = f[0];
                    }
                }
                break;
            default:
                break;
        }
    }

    return formData;
}

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
            case 'employee_id':
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

export const getModalID = (entityID, entityType) => {
    return `edit-${entityType}-${entityID}`;
}
