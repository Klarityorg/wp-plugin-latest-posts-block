import './style.scss';
import './editor.scss';

const {__} = wp.i18n;
const {registerBlockType} = wp.blocks;
const { ServerSideRender } = wp.editor;

const el = wp.element.createElement;
const iconEl = el('svg', { width: 128, height: 128, viewBox: "0 0 128 128" },
	el('rect', { x: 0, y: 0, width: 128, height: 128, stroke: "white" }),
	el('path', { d: "M41.7607 39.0615H52.8432V60.866L73.2637 39.0615H86.6547L66.1434 60.2237L87.5885 88.9388H74.2753L58.66 67.706L52.8432 73.6982V88.9388H41.7607V39.0615Z", fill: "white" })
);

registerBlockType('klarity/klarity-latest-posts-block', {
	title: __('Latest posts'),
	icon: iconEl,
	category: 'layout',
	attributes: {
		numberOfPosts: {
			type: 'string',
			default: ''
		}
	},
	edit: props => {
		let {attributes: {numberOfPosts}, setAttributes} = props;
		const setNumberOfPosts = event => {
		  const selected = event.target;
		  setAttributes({numberOfPosts: selected.value})
		  event.preventDefault();
		};
		return <div>
		<label htmlFor="number-of-posts-input">Number of posts:
			<input id="number-of-posts-input" type="number" value={numberOfPosts} onChange={setNumberOfPosts}/>
		</label>
		<ServerSideRender
			block="klarity/klarity-latest-posts-block"
			attributes={ props.attributes } />
		</div>
	},

	save: props => {
		return null;
	},
});
