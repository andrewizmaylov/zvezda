import {requestWrapper} from '@/api/apiHelper';

export async function uploadFileRequest(file, sourceType) {
    const formData = new FormData();

    formData.append('file', file);

    return requestWrapper(axios.post('/files', formData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    }));
}

export async function deleteFileRequest(id) {
    return requestWrapper(axios.delete('/files/' + id));
}

export async function downloadFileRequest(file) {
    try {
        const res = await axios.get('/files/' + file.id + '/download', {responseType: 'arraybuffer'});

        const blob = new Blob([res.data], {
            type: res.headers['content-type']
        });
        const link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.download = file.file_name;
        link.click();
    } catch (e) {
    }
}
