XEeditor.tools.define({
	id : 'editortool/image_resize_tool@image_resize_crop',
	events: {
		iconClick: function(targetEditor, cbAppendToolContent) {
			if(targetEditor.config.perms.upload) {
				var $uploadArea = $(targetEditor.container.$).parent().find('.ckeditor-fileupload-area');
				// var currentFilesSize = parseFloat($uploadArea.find('.currentFilesSize').text());

				var uploadUrl = targetEditor.config.fileUpload.upload_url;
				var attachMaxSize = targetEditor.config.attachMaxSize;
				var fileMaxSize = targetEditor.config.fileMaxSize;
				var extensions = targetEditor.config.extensions;

				var cWindow = window.open(imageResizeURL.get('popup'), 'createImageResizerPopup', "width=850,height=970,directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no");

				$(cWindow).on('load', function() {
					cWindow.targetEditor = targetEditor;
					cWindow.appendToolContent = cbAppendToolContent;
					cWindow.uploadInfo = {
						uploadUrl: uploadUrl,
						attachMaxSize: attachMaxSize,
						fileMaxSize: fileMaxSize,
						extensions: extensions,
						$uploadArea: $uploadArea
					};
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