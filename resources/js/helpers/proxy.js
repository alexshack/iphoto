import { isProxy, toRaw } from 'vue';

export const getData = (data) =>  {
    if (isProxy(data)) {
        return toRaw(data);
    }
    return data;
}
