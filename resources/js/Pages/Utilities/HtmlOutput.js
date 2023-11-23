import {copyClipboard, copyContent} from '@/Pages/Shared/helpers.js';
// base classes for school content container
const schoolDefault = ['w-full', 'mx-auto'];

function getClasses(obj) {
	let classArray = [];
	if (typeof obj.class === 'undefined') {
		return null;
	} else {
		if (obj.stretched !== undefined && obj.stretched === true) {
			classArray = obj.class.join(' ');
		} else {
			classArray = schoolDefault.concat(obj.class.filter((item) => schoolDefault.indexOf(item) < 0)).join(' ');
		}
		return classArray;
	}
}

export function convertCamelStylesToString(obj, objKey='style') {
	// console.log('obj styles: ', obj);
	
	if (typeof obj[objKey] == 'undefined') {
		// console.log('no style: ', typeof obj[objKey]);
		return null;
	} else {
		let str = '';
		if (Object.keys(obj[objKey]).length !== 0) {
			for (let key in obj[objKey]) {
				// console.log('obj[objKey]', obj[objKey]);
				// console.log('${obj[objKey][key]}', obj[objKey][key]);
				
				
				str += `${key.replace(/[A-Z]/g, '-$&').toLowerCase()}: ${obj[objKey][key].replace(/[A-Z]/g, '-$&').toLowerCase()}; `;
				// console.log('str', str);
				
			}
		}
		return str;
	}
}
function makeTable(obj) {
	let out = `
<div class="mt-8 flex flex-col">
  <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
    <div class="inline-block min-w-full py-2 align-middle">
      <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg mx-1">
        <table class="min-w-full divide-y divide-gray-300">
          <thead class="bg-gray-50">
            <tr>`;
	obj.data.content[0].forEach(key => out += '<th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8">'+key+'</th>');
	
	out += `</tr>
          </thead>
          <tbody class="divide-y divide-gray-200 bg-white">`;
	
	obj.data.content.slice(1).forEach(row => {
		out += '<tr>';
		row.forEach(key => out += '<td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">'+key+'</td>');
		out += '</tr>';
	});
	out += `</tbody>
        </table>
      </div>
    </div>
  </div>
</div>`;
	return out;
}

function makeColumns(obj) {
	let out = `<div class="grid grid-cols-${obj.data.cols.length} gap-3 -my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8 mt-8">`;
	obj.data.cols.forEach(col => {
		out += `<div class="md:col-span-1 col-span-${obj.data.cols.length} rounded">`;
		col.blocks.forEach(block => {
			let function_name = 'make'+_.upperFirst(block.type);
			out += makeParagraph(block);
		});
		out += '</div>';
		
	});
	
	out += '</div>';
	return out;
	
}

function makeHeader(obj) {
	switch (obj.data.level) {
		case 1:
			return `<h1 class="ce-header">${obj.data.text}</h1>`;
		case 2:
			return `<h2 class="ce-header">${obj.data.text}</h2>`;
		case 3:
			return `<h3 class="ce-header">${obj.data.text}</h3>`;
		case 4:
			return `<h4 class="ce-header">${obj.data.text}</h4>`;
		case 5:
			return `<h5 class="ce-header">${obj.data.text}</h5>`;
		case 6:
			return `<h6 class="ce-header">${obj.data.text}</h6>`;
	}
}


function makeImage(obj) {
	const caption = obj.data.caption ? obj.data.caption : '';
	if (caption) {
		return `
      <div class="ejs_image_wrapper">
        <div class="ejs_image_container"><img class="ejs_image" src="${obj.data.file.url}" :alt="${caption}"></div>
        <div class="ejs_image_caption">${caption}</div>
      </div>
      `;
	} else {
		return `
        <div class="ejs_image_wrapper">
          <div class="ejs_image_container"><img class="ejs_image" src="${obj.data.file.url}" alt="image"></div>
        </div>
      `;
	}
}

function makeParagraph(obj) {
	return `<div class="ce-paragraph">${obj.data.text}</div>`;
}

function makeList(obj) {
	let list_items = '';
	obj.data.items.map(row => list_items += `<li class="ejs_list">${row}</li>`);
	
	return `<div class="my-5">${list_items}</div>`;
}



function makePersonality(obj) {
	const name = obj.data.name.text ? obj.data.name.text : '';
	const company = obj.data.company.text ? obj.data.company.text : '';
	const description = obj.data.description.text ? obj.data.description.text : '';
	const uid = obj.data.uid.text ? obj.data.uid.text : '';
	const photo = obj.data.photo.url ? obj.data.photo.url : 'https://nord.test/img/avatar2.svg';
	const wrapperClass = obj.data.stretched ? obj.data.wrapper.class.join(' ') : schoolDefault.concat(obj.data.wrapper.class.filter((item) => schoolDefault.indexOf(item) < 0)).join(' ');
	
	return `
    <div class="${wrapperClass}" style="${convertCamelStylesToString(obj.data.wrapper)}">
      <div class="${obj.data.imageWrapper.class.join(' ')}" style="${convertCamelStylesToString(obj.data.imageWrapper)}">
        <img src="${photo}" alt="userImage" class="${obj.data.photo.class.join(' ')}" style="${convertCamelStylesToString(obj.data.photo)}"/>
      </div>
      <section class="${obj.data.text.class.join(' ')}">
        <div class="${obj.data.company.class.join(' ')}" style="${convertCamelStylesToString(obj.data.company)}">${company}</div>
        <div class="${obj.data.name.class.join(' ')}" style="${convertCamelStylesToString(obj.data.name)}">${name}</div>
        <div class="${obj.data.description.class.join(' ')}" style="${convertCamelStylesToString(obj.data.description)}">${description}</div>
        <div class="${obj.data.uid.class.join(' ')}" style="${convertCamelStylesToString(obj.data.uid)}">${uid}</div>
      </section>
    </div>
  `;
}
function escapeHtml(text) {
	var map = {
		'&': '&amp;',
		'<': '&lt;',
		'>': '&gt;',
		'"': '&quot;',
		'\'': '&#039;'
	};
	
	return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}

function makeCode(obj) {
	console.log('code', obj);
	const code = escapeHtml(obj.data.code);
	let id = (Math.random() + 1).toString(34).substr(2);
	
	return `
<div class="w-full mx-auto my-4 relative overflow-auto md:text-[14px] text-[12px] bg-red-200">
<svg xmlns="http://www.w3.org/2000/svg" id="copy_${id}" onclick="copyClipboard('${id}')" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 absolute mt-2 right-2 cursor-pointer text_ld opacity-80 hover:opacity-100"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75"/></svg>
<svg xmlns="http://www.w3.org/2000/svg" id="copy_done_${id}" fill="none" stroke="currentColor" stroke-width="1.5" class="w-4 h-4 absolute mt-2 right-2 cursor-pointer text_ld opacity-80 hover:opacity-100 hidden" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg>
<section class="bg_ld text-[12px] text_ld p-4 font-mono leading-6 whitespace-pre rounded resize-y border dark:border-[#808080] border-[#f1f1f4] shadow-none max-h-[250px] overflow-auto">
<pre class="w-32 mx-2" id="${id}">
${code}
</pre>
</section>
</div>`;
}


function makeQuote(obj) {
	return `<div class="w-2/3 block my-4 bg-green-100 p-6 rounded">
              <blockquote>
                <p class="text-lg font-serif mb-4">
                  ${obj.data.text}
                </p>
              </blockquote>
              <p class="my-2 text-xs">- ${obj.data.caption}</p>
            </div>`;
}
function makeDelimiter(obj) {

}
function makeWarning(obj) {
	return `<section class="bg-red-100 w-full text-center py-12 rounded">
              <div class="">
                <h3><span><i class="fas fa-exclamation"></i></span>${obj.data.title}</h3>
                <p>${obj.data.message}</p>
              </div>
            </section>`;
}
function makeChecklist(obj) {
	const list = obj.data.items.map(item => {
		return `
        <div class="_1checkbox">
          <span class="_1checkbox_round"></span>
          ${item.text}
        </div>`;
	});
	
	return `
      <section class="">
        <div class="">
          <div class="">
            <div class="">
              ${list.join('')}
            </div>
          </div>
        </div>
      </section>`;
}
function makeEmbed(obj) {
	const caption = obj.data.caption ? `
      <div class="">
        <p class=""> ${obj.data.caption}</p>
      </div>` : '';
	
	return `
      <section class="">
        <div class="">
          <div class="">
            <iframe width="730" height="415" src="${obj.data.embed}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>
          ${caption}
        </div>
      </section>`;
}

function makeVideo(obj) {
	if (obj.data.url) {
		return `<div style="margin: 0 auto;" class="m_bottom xl:w-2/3">
            <video src="${obj.data.url}" controls controlsList="nodownload" poster="${obj.data.cover_url}"/>
          </div>`;
	}
	return '';
}

function makeBtn(obj) {
	if (obj.data.parentId) {
		return `<div class="btnEditor m_bottom xl:w-2/3 w-full mx-auto" ">
                        <div class="next_btn d_none" style="${obj.data.style}" data-elId="${obj.data.elId}" data-parentId="${obj.data.parentId}" onclick="open_content(this, this.dataset.elid)">
                            ${obj.data.des}
                        </div>
            </div>`;
	}
	return `<div class="btnEditor m_bottom xl:w-2/3 w-full mx-auto" ">
                        <div class="next_btn" style="${obj.data.style}" data-elId="${obj.data.elId}" onclick="open_content(this, this.dataset.elid)">
                            ${obj.data.des}
                        </div>
            </div>`;
}

function makeHTML(obj) {
	if (obj.data.js) {
		let js = document.createElement('script');
		js.text = obj.data.js;
		document.body.appendChild(js);
	}
	if (obj.data.html) {
		return obj.data.html;
	}
}

export function htmlOutput(data) {
	let html_code = '';
	
	data.blocks.map(obj => {
		switch (obj.type) {
			case 'paragraph':
				html_code += makeParagraph(obj);
				break;
			case 'image':
				html_code += makeImage(obj);
				break;
			case 'header':
				html_code += makeHeader(obj);
				break;
			case 'table':
				html_code += makeTable(obj);
				break;
			case 'columns':
				html_code += makeColumns(obj);
				break;
			case 'list':
				html_code += makeList(obj);
				break;
			case 'personality':
				html_code += makePersonality(obj);
				break;
			case 'code':
				html_code += makeCode(obj);
				break;
			case 'embed':
				html_code += makeEmbed(obj);
				break;
			case 'quote':
				html_code += makeQuote(obj);
				break;
			case 'delimiter':
				html_code += makeDelimiter(obj);
				break;
			case 'warning':
				html_code += makeWarning(obj);
				break;
			case 'checklist':
				html_code += makeChecklist(obj);
				break;
			case 'video':
				html_code += makeVideo(obj);
				break;
			case 'button':
				html_code += makeBtn(obj);
				break;
			case 'html':
				html_code += makeHTML(obj);
				break;
		}
	});
	return html_code;
}
