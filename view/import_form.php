<div class="wrap">
	<h1><?php _e( 'Import/Export', 'formidable' ); ?></h1>
	
	<?php include( FrmAppHelper::plugin_path() . '/classes/views/shared/errors.php' ); ?>
	<div id="poststuff" class="metabox-holder">
		<div id="post-body">
			<div id="post-body-content">

				<div class="postbox ">
					<h3 class="hndle"><span><?php _e( 'Import', 'formidable' ) ?></span></h3>
					<div class="inside">
						<p class="howto"><?php echo apply_filters( 'frm_upload_instructions1', __( 'Upload your Formidable XML file to import forms into this site. If your imported form key and creation date match a form on your site, that form will be updated.', 'formidable' ) ) ?></p>
						<br/>
						<form enctype="multipart/form-data" method="post">
							<input type="hidden" name="frm_action" value="import_xml"/>
							<?php wp_nonce_field( 'import-xml-nonce', 'import-xml' ); ?>
							<p><label><?php echo apply_filters( 'frm_upload_instructions2', __( 'Choose a Formidable XML file', 'formidable' ) ) ?> (<?php printf( __( 'Maximum size: %s', 'formidable' ), ini_get( 'upload_max_filesize' ) ) ?>)</label>
								<input type="file" name="frm_import_file" size="25"/>
							</p>
							
							<?php do_action( 'frm_csv_opts', $forms ) ?>

							<p class="submit">
								<input type="submit" value="<?php esc_attr_e( 'Upload file and import', 'formidable' ) ?>" class="button-primary"/>
							</p>
						</form>
						<?php FrmTipsHelper::pro_tip( 'get_import_tip' ); ?>
					</div>
				</div>


			</div>
		</div>
	</div>
</div>
