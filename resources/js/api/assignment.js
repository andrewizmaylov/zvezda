import {requestWrapper} from "@/api/apiHelper";

export async function getAssignmentTreadRequest(courseId, lessonId) {
    return await requestWrapper(axios.post(`/assignments/lesson/${courseId}/${lessonId}/tread`));
}

export async function readAssignmentMessagesRequest(messagesIds) {
    return await requestWrapper(axios.patch(`/assignments/messages/read`, {
        messages_ids: messagesIds
    }));
}

export async function sendAssignmentMessageRequest(assignment, message, files_ids) {
    return await requestWrapper(axios.post(`/assignments/${assignment.id}/message`, {
        message,
        files_ids,
    }))
}

export async function retakeAssignmentRequest(courseId, lessonId) {
    return await requestWrapper(axios.post(`/assignments/lesson/${courseId}/${lessonId}/retake`));
}

// http://ps-school.test/38d799de/960eab2f-3c13-4dd7-ac5d-aff05547c313?tab=practice
