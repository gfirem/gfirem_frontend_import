<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class GFireMFrontendImportXml extends FrmXMLController {
	
	public static function route() {
		$action = isset( $_REQUEST['frm_action'] ) ? 'frm_action' : 'action';
		$action = FrmAppHelper::get_param( $action, '', 'get', 'sanitize_title' );
		if ( $action == 'import_xml' ) {
			return self::import_xml();
		} else if ( $action == 'export_xml' ) {
			return self::export_xml();
		} else {
			if ( apply_filters( 'frm_xml_route', true, $action ) ) {
				return self::form();
			}
		}
	}
	
	public static function form( $errors = array(), $message = '' ) {
		$where = array(
			'status' => array( null, '', 'published' ),
		);
		$forms = FrmForm::getAll( $where, 'name' );
		$export_types = apply_filters( 'frm_xml_export_types', array( 'forms' => __( 'Forms', 'formidable' ), 'items' => __( 'Entries', 'formidable' ) ) );
		$export_format = apply_filters( 'frm_export_formats', array(
			'xml' => array( 'name' => 'XML', 'support' => 'forms', 'count' => 'multiple' ),
			'csv' => array( 'name' => 'CSV', 'support' => 'items', 'count' => 'single' ),
		) );
		include GFireMFrontendImport::$view_path . 'import_form.php';
	}
}