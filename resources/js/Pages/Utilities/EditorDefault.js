import Header from '@editorjs/header';
import Image from '@editorjs/image';
import List from '@editorjs/list';
import Table from '@editorjs/table';
import Embed from '@editorjs/embed';

import LinkTool from '@editorjs/link';
import Hyperlink from 'editorjs-hyperlink';
import InlineCode from '@editorjs/inline-code';
import CodeTool from '@editorjs/code';
import InlineCodeSelf from '@/Pages/Utilities/InlineCodeSelf.js';
import Cookies from 'js-cookie';
import {FileSourcesEnum} from '@/Enums/FileSourcesEnum.js';
import {cloud_path} from '@/Pages/Shared/helpers.js';



export const tools_default = {
	header: {
		class: Header,
		inlineToolbar: ['bold', 'italic', 'hyperlink', 'inlineCode'],
		config: {
			placeholder: 'Enter a header',
			levels: [1, 2, 3, 4, 5, 6],
			defaultLevel: 3
		}
	},
	image: {
		class: Image,
		inlineToolbar: ['bold', 'italic', 'hyperlink'],
		config: {
			// endpoints: {
			// 	byFile: '/files/tmp', // Your backend file uploader endpoint
			// 	// byFile: window.location.origin+'/change_image', // Your backend file uploader endpoint
			// 	byUrl: window.location.origin+'/fetchUrl', // Your endpoint that provides uploading by Url
			// },
			uploader: {
				/**
				 * Upload file to the server and return an uploaded image data
				 * @param {File} file - file selected from the device or pasted by drag-n-drop
				 * @return {Promise.<{success, file: {url}}>}
				 */
				uploadByFile(file) {
					const formData = new FormData();
					formData.append('file', file);
					formData.append('source', FileSourcesEnum.ContentImage);
					
					return fetch('/files/tmp', {
						method: 'POST',
						body: formData,
						headers: {
							'X-XSRF-TOKEN': Cookies.get('XSRF-TOKEN'),
						}
					}).then(response => response.json())
						.then(result => {
							console.log('result.file', result.file);
							return {
								success: 1,
								file: {
									url: cloud_path + result.file.link
									// other properties like width, height, etc. can also be included
								}
							};
						});
				},
				uploadByUrl(url){
					const formData = new FormData();
					formData.append('url', url);
					formData.append('source', FileSourcesEnum.ContentImage);
					
					return fetch('/files/uploadByUrl', {
						method: 'POST',
						body: formData,
						headers: {
							'X-XSRF-TOKEN': Cookies.get('XSRF-TOKEN'),
						}
					}).then(response => response.json())
						.then(result => {
							console.log('result.file', result.file);
							return {
								success: 1,
								file: {
									url: cloud_path + result.file.link
									// other properties like width, height, etc. can also be included
								}
							};
						});
				}
			},
			headers: {
				'X-XSRF-TOKEN': Cookies.get('XSRF-TOKEN')
			}
		}
	},
	list: {
		class: List,
		inlineToolbar: ['bold', 'italic', 'hyperlink', 'inlineCode'],
	},
	table: {
		class: Table,
		inlineToolbar: true,
		config: { rows: 2, cols: 3, },
	},
	embed: {
		class: Embed,
		inlineToolbar: true,
		config: {
			services: {
				youtube: true,
				coub: true,
				codepen: {
					regex: /https?:\/\/codepen.io\/([^\/\?\&]*)\/pen\/([^\/\?\&]*)/,
					embedUrl: 'https://codepen.io/<%= remote_id %>?height=300&theme-id=0&default-tab=css,result&embed-version=2',
					html: '<iframe height=\'300\' scrolling=\'no\' frameborder=\'no\' allowtransparency=\'true\' allowfullscreen=\'true\' style=\'width: 100%;\'></iframe>',
					height: 300,
					width: 600,
					id: (groups) => groups.join('/embed/')
				}
			}
		}
	},
	code: CodeTool,
	// https://github.com/editor-js/link
	linkTool: {
		class: LinkTool,
		config: {
			endpoint: 'http://localhost:8008/fetchUrl', // Your backend endpoint for url data fetching,
		}
	},
	hyperlink: {
		class: Hyperlink,
		config: {
			shortcut: 'CMD+L',
			target: '_blank',
			rel: 'nofollow',
			availableTargets: ['_blank', '_self'],
			availableRels: ['author', 'noreferrer'],
			validate: false,
		}
	},
	inlineCode: {
		class: InlineCode,
		shortcut: 'CMD+SHIFT+M',
	},
	InlineCodeSelf: {
		class: InlineCodeSelf
	}
};

