import {computed} from 'vue';
import {usePage} from '@inertiajs/vue3';
// import {useI18n} from 'vue-i18n';
// const { t } = useI18n();

export const page = usePage();
export const lorem_text = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ea, eius, sapiente. Adipisci assumenda dolores eaque inventore quis. Asperiores consectetur doloribus in iure labore minima perspiciatis recusandae, reiciendis, sed sunt suscipit?';
export const cloud_path = 'https://storage.yandexcloud.net/fczvezda/';

export const default_image = '/img/empty.svg';

export const initials = computed(() => {
	let first_name =  page.props?.auth?.user?.contact?.first_name ?? 0;
	let last_name =  page.props?.auth?.user?.contact?.last_name ?? 0;
	
	return first_name.substring(0,1)+last_name.substring(0,1);
});

export const full_name = computed(() => {
	let first_name =  page.props?.auth?.user?.contact?.first_name ?? 'John';
	let last_name =  page.props?.auth?.user?.contact?.last_name ?? 'Dow';
	
	return first_name + ' ' + last_name;
});

export function checkAccess(input) {
	let out = false;
	
	input.forEach(role => {
		if (page?.props?.auth?.roles && page?.props?.auth?.roles.map(role => Number(role)).includes(role)) {
			out = true;
		}
	});
	return out;
}

export function copyClipboard(id) {
	console.log(id, 'copyClipboard');
	const el_clipBoArd = document.createElement('textarea');
	el_clipBoArd.value = id;
	el_clipBoArd.setAttribute('readonly', '');
	el_clipBoArd.style.position = 'absolute';
	el_clipBoArd.style.left = '-9999px';
	document.body.appendChild(el_clipBoArd);
	el_clipBoArd.select();
	document.execCommand('copy');
	document.body.removeChild(el_clipBoArd);
}

export function copyContent(id) {
	let out = document.getElementById(id).textContent;
	document.getElementById(`copy_${id}`).classList.add('hidden');
	document.getElementById(`copy_done_${id}`).classList.remove('hidden');
	setTimeout(() => {
		document.getElementById(`copy_done_${id}`).classList.add('hidden');
		document.getElementById(`copy_${id}`).classList.remove('hidden');
	}, 1000);
	const el_clipBoArd = document.createElement('textarea');
	el_clipBoArd.value = out;
	el_clipBoArd.setAttribute('readonly', '');
	el_clipBoArd.style.position = 'absolute';
	el_clipBoArd.style.left = '-9999px';
	document.body.appendChild(el_clipBoArd);
	el_clipBoArd.select();
	document.execCommand('copy');
	document.body.removeChild(el_clipBoArd);
}

export async function getTheGame(game) {
	return await axios.post(route('get_team_for_game'), {
		game_id: game.id,
		team_a: game.team_a,
		team_b: game.team_b,
	});
}