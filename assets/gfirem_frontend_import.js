function frmImportCsv(formID) {
	var urlVars = '';
	if (typeof __FRMURLVARS != 'undefined') {
		urlVars = __FRMURLVARS;
	}

	jQuery.ajax({
		type: "POST", url: ajaxurl,
		data: 'action=frm_import_csv&nonce=' + gfirem_frontend_import.nonce + '&frm_skip_cookie=1' + urlVars,
		success: function (count) {
			var max = jQuery('.frm_admin_progress_bar').attr('aria-valuemax');
			var imported = max - count;
			var percent = (imported / max) * 100;
			jQuery('.frm_admin_progress_bar').css('width', percent + '%').attr('aria-valuenow', imported);

			if (parseInt(count) > 0) {
				jQuery('.frm_csv_remaining').html(count);
				frmImportCsv(formID);
			} else {
				jQuery(document.getElementById('frm_import_message')).html(gfirem_frontend_import.import_complete);
				setTimeout(function () {
					location.href = '?page=formidable-entries&frm_action=list&form=' + formID + '&import-message=1';
				}, 2000);
			}
		}
	});
}