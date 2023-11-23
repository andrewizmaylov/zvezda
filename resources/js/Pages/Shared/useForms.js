import {router} from '@inertiajs/vue3';

export function submitForm(form, model) {
	console.log(form, model);
	form.post(route(model_route(model) + '.store'), {
		errorBag: 'updateInformation',
		preserveScroll: true,
	});
}
export function updateForm(form, model) {
	form.put(route(model_route(model)+'.update', {slug: form.slug, id: form.id}), {
		errorBag: 'updateInformation',
		preserveScroll: true,
		onSuccess: () => {
			Event.emit('form_updated');
		}
	});
}

export function updateDetails(data) {
	axios.post(route('update_details'), data).then(response => {
		Event.emit('successfully_updated');
		router.reload({only: ['input']});
	});
}

export const default_fields = [
	'id','name','slug','description','details','published_at',
];
export const game_fields = [
	'image','date','time','team_a','team_b','stadium_id',
];
export const news_fields = [
	'image','schema','user_id','team_id',
];
export const team_fields = [
	'logo','banner',
];
export const partner_fields = [
	'logo','banner',
];
export const merch_fields = [
	'image',
];
export const position_fields = [
	'image',
];
export const user_fields = [
	'id','email','profile_photo_path','first_name','second_name','last_name','birthday','tg','role'
];
export const model_route = (model) => {
	return ['news','merch'].includes(model) ? model : model+'s';
};