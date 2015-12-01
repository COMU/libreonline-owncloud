(function(OCA) {

	OCA.LibreOnline = OCA.LibreOnline || {};
	OCA.LibreOnline.Viewer = {


		attach: function(fileList) {
			this._extendFileActions(fileList.fileActions);
		},

		hide: function() {
			$('#loframe').remove();
			if ($('#isPublic').val() && $('#filesApp').val()){
				$('#controls').removeClass('hidden');
			}

			FileList.setViewerMode(false);

			$('#app-content #controls').removeClass('hidden');
		},


		show: function(downloadUrl, isFileList) {
			var self = this;
			var $iframe;
			var viewer = OC.generateUrl('/apps/libreonline/?file={file}', {file: downloadUrl});
			$iframe = $('<iframe id="loframe" style="width:100%;height:100%;display:block;position:absolute;top:0;" src="'+viewer+'" />');

			if(isFileList === true) {
				FileList.setViewerMode(true);
			}

			if ($('#isPublic').val()) {
				$('#preview').append($iframe).css({height: '100%'});
				$('body').css({height: '100%'});
				$('footer').addClass('hidden');
				$('#imgframe').addClass('hidden');
				$('.directLink').addClass('hidden');
				$('.directDownload').addClass('hidden');
				$('#controls').addClass('hidden');
			} else {
				$('#app-content').append($iframe);
			}

			$("#pageWidthOption").attr("selected","selected");
			$('#app-content #controls').addClass('hidden');

			$('#loframe').load(function(){
				var iframe = $('#loframe').contents();
				if ($('#fileList').length) {
					iframe.find('#secondaryToolbarClose').click(function() {
						self.hide();
					});
				} else {
					iframe.find("#secondaryToolbarClose").addClass('hidden');
				}
			});
		},


		_extendFileActions: function(fileActions) {


			var self = this;

			mimes = ['application/msword',
					 'application/msword',
					 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
					 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
					 'application/vnd.ms-word.document.macroEnabled.12',
					 'application/vnd.ms-word.template.macroEnabled.12',
					 'application/vnd.ms-excel',
					 'application/vnd.ms-excel',
					 'application/vnd.ms-excel',
					 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
					 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
					 'application/vnd.ms-excel.sheet.macroEnabled.12',
					 'application/vnd.ms-excel.template.macroEnabled.12',
					 'application/vnd.ms-excel.addin.macroEnabled.12',
					 'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
					 'application/vnd.ms-powerpoint',
					 'application/vnd.ms-powerpoint',
					 'application/vnd.ms-powerpoint',
					 'application/vnd.ms-powerpoint',
					 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
					 'application/vnd.openxmlformats-officedocument.presentationml.template',
					 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
					 'application/vnd.ms-powerpoint.addin.macroEnabled.12',
					 'application/vnd.ms-powerpoint.presentation.macroEnabled.12',
					 'application/vnd.ms-powerpoint.template.macroEnabled.12',
					 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12',
					 'application/vnd.oasis.opendocument.chart',
					 'application/vnd.oasis.opendocument.chart-template',
					 'application/vnd.oasis.opendocument.formula',
					 'application/vnd.oasis.opendocument.formula-template',
					 'application/vnd.oasis.opendocument.graphics',
					 'application/vnd.oasis.opendocument.graphics-template',
					 'application/vnd.oasis.opendocument.image',
					 'application/vnd.oasis.opendocument.image-template',
					 'application/vnd.oasis.opendocument.presentation',
					 'application/vnd.oasis.opendocument.presentation-template',
					 'application/vnd.oasis.opendocument.spreadsheet',
					 'application/vnd.oasis.opendocument.spreadsheet-template',
					 'application/vnd.oasis.opendocument.text',
					 'application/vnd.oasis.opendocument.text-master',
					 'application/vnd.oasis.opendocument.text-template',
					 'application/vnd.oasis.opendocument.text-web',
					 'application/vnd.oasis.opendocument.database',
					 ]

			for (var _mime in mimes){
				fileActions.registerAction({
					name: 'view',
					displayName: 'Favorite',
					mime: mimes[_mime],
					permissions: OC.PERMISSION_READ,
					actionHandler: function(fileName, context) {
						var downloadUrl = '';
						if($('#isPublic').val()) {
							var sharingToken = $('#sharingToken').val();
							downloadUrl = OC.generateUrl('/s/{token}/download?files={files}&path={path}', {
								token: sharingToken,
								files: fileName,
								path: context.dir
							});
						} else {
							downloadUrl = Files.getDownloadUrl(fileName, context.dir);
						}
						self.show(context.dir+ '/' + fileName, true);
					}
				});
				fileActions.setDefault(mimes[_mime], 'view');
			}
				
		}
	};

})(OCA);

if(!$.browser.msie || ($.browser.msie && $.browser.version >= 9)){
	OC.Plugins.register('OCA.Files.FileList', OCA.LibreOnline.Viewer);
}