(function (wp) {

	var registerBlockType = wp.blocks.registerBlockType,
		createElement = wp.element.createElement,
		__ = wp.i18n.__,
		InspectorControls = wp.editor.InspectorControls,
		TextControl = wp.components.TextControl,
		ServerSideRender = wp.components.ServerSideRender;

	registerBlockType('boffo/boffo', {

		title: __('Boffo block', 'boffo'),
		category: 'widgets',
		supports: {
			// Removes support for an HTML mode.
			html: false,
		},
		attributes: {
			boffo_id: {
				type: 'string',
				default: null
			},
		},

		/**
		 * @param {Object} [props] Properties passed from the editor.
		 * @return {Element}       Element to render.
		 */
		edit: function (props) {
			var boffo_id = props.attributes.boffo_id || '';

			var controlOptions = {
				value: boffo_id,
				onChange: function (newVal) {
					props.setAttributes({
						boffo_id: newVal
					});
				},
				placeholder: __('Paste or enter your Boffo Flow ID'),
			};

			var serverSideEl = createElement(ServerSideRender, {
				block: 'boffo/boffo',
				attributes: props.attributes
			});

			return createElement('div', {}, [
				serverSideEl,
				createElement(InspectorControls, {}, [
					createElement(TextControl, controlOptions)
				])
			]);
		},

		/**
		 * @return {Element}       Element to render.
		 */
		save: function (props) {
			return null;
		}
	});
})(
	window.wp
);
