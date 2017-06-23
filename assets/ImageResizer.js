XEeditor.tools.define({
	id : 'editortool/image_resize_tool@image_resize_crop',
	events: {
		iconClick: function(targetEditor, cbAppendToolContent) {
			if(targetEditor.config.perms.upload) {
				var cWindow = window.open(imageResizeURL.get('popup'), 'createImageResizerPopup', "width=850,height=930,directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no");

				$(cWindow).on('load', function() {
					cWindow.targetEditor = targetEditor;
					cWindow.appendToolContent = cbAppendToolContent;
				});
			}
		},
		elementDoubleClick: function() {

		},
		beforeSubmit: function(targetEditor) {

		},
		editorLoaded: function(targetEditor) {
			if(!targetEditor.config.perms.upload) {
				$('.cke_button__imageresizer').addClass('cke_button_disabled');
			}
		}
	},
	props: {
		name: 'ImageResizer',
		options: {
			label: '이미지 편집',
			command: 'openImageResizer'
		},
		addEvent: {
			doubleClick: false
		}
	}
});