export async function requestWrapper(promise) {
    try {
        return await (new Promise((resolve) => {
            promise
                .then((res) => {
                    resolve(Object.assign(res.data, {
                        success: res.data.success ? res.data.success : true
                    }));
                })
                .catch((e) => {
                    resolve(Object.assign(e.response.data, {
                        'success': false,
                        'message': e.message ? e.message : 'Что-то пошло не так'
                    }));
                });
        }));
    } catch (e) {
        return {
            'success': false,
            'message': 'Что-то пошло не так',
        }
    }
}
