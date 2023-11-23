export default class InlineCodeSelf {
	/**
	 * Class name for term-tag
	 *
	 * @type {string}
	 */
	static get CSS() {
		return 'inline-code-self';
	}
	
	/**
	 */
	constructor({api}) {
		this.api = api;
		
		/**
		 * Toolbar Button
		 *
		 * @type {HTMLElement|null}
		 */
		this.button = null;
		
		/**
		 * Tag represented the term
		 *
		 * @type {string}
		 */
		this.tag = 'PRE';
		
		/**
		 * CSS classes
		 */
		this.iconClasses = {
			base: this.api.styles.inlineToolButton,
			active: this.api.styles.inlineToolButtonActive
		};
	}
	
	/**
	 * Specifies Tool as Inline Toolbar Tool
	 *
	 * @return {boolean}
	 */
	static get isInline() {
		return true;
	}
	
	/**
	 * Create button element for Toolbar
	 *
	 * @return {HTMLElement}
	 */
	render() {
		this.button = document.createElement('button');
		this.button.type = 'button';
		this.button.classList.add(this.iconClasses.base);
		this.button.innerHTML = this.toolboxIcon;
		
		return this.button;
	}
	
	/**
	 * Wrap/Unwrap selected fragment
	 *
	 * @param {Range} range - selected fragment
	 */
	surround(range) {
		if (!range) {
			return;
		}
		
		let termWrapper = this.api.selection.findParentTag(this.tag, InlineCodeSelf.CSS);
		
		/**
		 * If start or end of selection is in the highlighted block
		 */
		if (termWrapper) {
			this.unwrap(termWrapper);
		} else {
			this.wrap(range);
		}
	}
	
	/**
	 * Wrap selection with term-tag
	 *
	 * @param {Range} range - selected fragment
	 */
	wrap(range) {
		/**
		 * Create a wrapper for highlighting
		 */
		let span = document.createElement(this.tag);
		
		
		
		span.classList.add(InlineCodeSelf.CSS);
		
		/**
		 * SurroundContent throws an error if the Range splits a non-Text node with only one of its boundary points
		 * @see {@link https://developer.mozilla.org/en-US/docs/Web/API/Range/surroundContents}
		 *
		 * // range.surroundContents(span);
		 */
		let block_code = document.createElement('div');
		block_code.classList.add('w-32');
		block_code.appendChild(range.extractContents());
		span.appendChild(block_code);
		range.insertNode(span);
		
		/**
		 * Expand (add) selection to highlighted block
		 */
		this.api.selection.expandToTag(span);
	}
	
	/**
	 * Unwrap term-tag
	 *
	 * @param {HTMLElement} termWrapper - term wrapper tag
	 */
	unwrap(termWrapper) {
		/**
		 * Expand selection to all term-tag
		 */
		this.api.selection.expandToTag(termWrapper);
		
		let sel = window.getSelection();
		
		// remove styling on unwarp
		let {id} = sel.baseNode.parentElement;
		let removable = document.getElementById(id).querySelector('.w-32');
		removable.classList.remove('w-32');
		
		let range = sel.getRangeAt(0);
		
		let unwrappedContent = range.extractContents();
		
		/**
		 * Remove empty term-tag
		 */
		termWrapper.parentNode.removeChild(termWrapper);
		
		/**
		 * Insert extracted content
		 */
		range.insertNode(unwrappedContent);
		
		/**
		 * Restore selection
		 */
		sel.removeAllRanges();
		sel.addRange(range);
	}
	
	/**
	 * Check and change Term's state for current selection
	 */
	checkState() {
		const termTag = this.api.selection.findParentTag(this.tag, InlineCodeSelf.CSS);
		
		this.button.classList.toggle(this.iconClasses.active, !!termTag);
	}
	
	/**
	 * Get Tool icon's SVG
	 * @return {string}
	 */
	get toolboxIcon() {
		return '<svg width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 6 3.976 9.22a1 1 0 0 0 0 1.56L8 14M12 14l4.024-3.22a1 1 0 0 0 0-1.56L12 6" stroke="#4A4A4A" stroke-width="1.3" stroke-linecap="round"/></svg>';
	}
	
	/**
	 * Sanitizer rule
	 * @return {{span: {class: string}}}
	 */
	static get sanitize() {
		return {
			pre: {
				class: InlineCodeSelf.CSS
			}
		};
	}
}
