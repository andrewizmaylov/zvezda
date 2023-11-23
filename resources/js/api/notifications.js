import {requestWrapper} from "@/api/apiHelper";

export async function getPlatformNotificationsRequest() {
    return await requestWrapper(axios.get('/platform-notifications'));
}

export async function readPlatformNotificationsRequest(notificationsIds) {
    return await requestWrapper(axios.patch('/platform-notifications', {
        'notification_ids': notificationsIds,
    }));
}

export async function clearNotificationsRequest() {
    return requestWrapper(axios.delete('/platform-notifications'));
}
