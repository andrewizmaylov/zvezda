import {ref} from 'vue';

export default () => {
	const files = ref([]);
	function newFile(file) {
		Event.emit('new_file_uploaded', file);
		files.value.push(file);
	}
	
	function deleteFile(id) {
		files.value = files.value.filter((f) => f.id !== id);
	}
	
	function activateFilepond() {
		Event.emit('file_pond_upload');
	}
	
	return {
		files, newFile, deleteFile, activateFilepond
	};
};