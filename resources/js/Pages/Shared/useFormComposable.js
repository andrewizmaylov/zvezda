import {useForm} from '@inertiajs/vue3';
import {onMounted, ref} from 'vue';
import {default_fields, game_fields, merch_fields, news_fields, partner_fields, position_fields, team_fields} from '@/Pages/Shared/useForms.js';

export default (model) => {
	let keys = ref([]);
	function defineKeys() {
		switch(model) {
			case 'Team':
				keys.value = [...default_fields, ...team_fields];
				break;
			case 'Game':
				keys.value = [...default_fields, ...game_fields];
				break;
			case 'Stadium':
				keys.value = default_fields;
				break;
			case 'Merch':
				keys.value = [...default_fields, ...merch_fields];
				break;
			case 'News':
				keys.value = [...default_fields, ...news_fields];
				break;
			case 'Partner':
				keys.value = [...default_fields, ...partner_fields];
				break;
			case 'Position':
				keys.value = [...default_fields, ...position_fields];
				break;
		}
	}
	
	let form = useForm({
		id: '',
		name: '',
		description: '',
		slug: '',
		published_at: '',
		details: '',
		image: '',
		logo: '',
		banner: '',
		user_id: '',
		team_id: '',
		date: '',
		time: '',
		team_a: '',
		team_b: '',
		stadium_id: '',
	});
	
	// Ensure that `keys` is an array and `input` is an object.
	function fillForm(input) {
		if (Array.isArray(keys.value) && input && typeof input === 'object') {
			keys.value.forEach(key => {
				// Use Vue.set or form's reactive assignment method if available
				form[key] = input[key] || '';
			});
		}
	}
	
	function updateFormField(input) {
		// Ensure that `input.field` is a string and exists within `form`
		if (typeof input.field === 'string' && form.hasOwnProperty(input.field)) {
			form[input.field] = input.value;
			updateForm(form, model);
		}
	}
	
	function submitForm(form, model) {
		console.log('composable submitForm', form, model, model_route(model));
		form.post(route(model_route(model.toLowerCase()) + '.store'), {
			errorBag: 'updateInformation',
			preserveScroll: true,
		});
	}
	
	function updateForm(form, model) {
		// console.log('composable updateForm', form, model, model_route(model));
		
		form.put(route(model_route(model.toLowerCase()) + '.update', {slug: form.slug, id: form.id}), {
			errorBag: 'updateInformation',
			preserveScroll: true,
			onSuccess: () => {
				Event.emit('form_updated');
			}
		});
	}
	
	const model_route = (model) => {
		return ['news', 'merch'].includes(model) ? model : model + 's';
	};
	
	onMounted(() => {
		defineKeys();
	});
	
	return {
		form, updateFormField, fillForm, submitForm, updateForm
	};
};