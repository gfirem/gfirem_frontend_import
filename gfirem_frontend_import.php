<?php
/**
 * @package           GFireMFrontendImport
 * @copyright         2017 to Jam3
 *
 * @wordpress-plugin
 * Plugin Name:       GFireM Frontend Import
 * Plugin URI:        http://www.gfirem.com/
 * Description:       Import Entries from the Frontend, easy as it sound.
 * Version:           1.0.0
 * Author:            Guillermo Figueroa Mesa
 * Author URI:        http://www.gfirem.com
 * License:           Apache License 2.0
 * License URI:       http://www.apache.org/licenses/
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'GFireMFrontendImport' ) ) {
	/**
	 * Class GFireMFrontendImport
	 */
	class GFireMFrontendImport {
		/**
		 * Instance of this class.
		 *
		 * @var object
		 */
		protected static $instance = null;
		/**
		 * @var string
		 */
		public static $view_path;
		/**
		 * @var string
		 */
		public static $assets_url;
		
		/**
		 * Initialize the plugin.
		 */
		private function __construct() {
			self::$view_path  = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR;
			self::$assets_url = trailingslashit( plugin_dir_url( __FILE__ ) ) . 'assets/';
			if ( class_exists( 'FrmXMLController' ) ) {
				require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'gfirem_frontend_import_xml.php';
				new GFireMFrontendImportXml();
				add_filter( 'frm_xml_route', 'FrmProXMLController::route', 10, 2 );
				add_filter( 'frm_upload_instructions1', 'FrmProXMLController::csv_instructions_1' );
				add_filter( 'frm_upload_instructions2', 'FrmProXMLController::csv_instructions_2' );
				add_action( 'frm_csv_opts', 'FrmProXMLController::csv_opts' );
				add_filter( 'frm_csv_where', 'FrmProXMLController::csv_filter', 1, 2 );
				add_filter( 'frm_csv_row', 'FrmProXMLController::csv_row', 10, 2 );
				add_filter( 'frm_csv_value', 'FrmProXMLController::csv_field_value', 10, 2 );
				add_filter( 'frm_xml_export_types', 'FrmProXMLController::xml_export_types' );
				add_filter( 'frm_export_formats', 'FrmProXMLController::export_formats' );
				add_action( 'frm_before_import_csv', 'FrmProXMLController::map_csv_fields' );
				add_shortcode( 'gfirem_import_form', array( $this, 'gfirem_import_form_callback' ) );
				add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_script' ) );
				
			}
		}
		
		public function enqueue_script() {
			wp_enqueue_script( 'gfirem_frontend_import', GFireMFrontendImport::$assets_url . 'gfirem_frontend_import.js', array(), false, true );
			wp_localize_script( 'gfirem_frontend_import', 'gfirem_frontend_import', array(
				'nonce' => wp_create_nonce( 'frm_ajax' ),
				'import_complete'   => __( 'Import Complete', 'formidable' ),
			) );
		}
		
		/**
		 * Show the form to handle the import view
		 *
		 * @param      $attr
		 * @param null $content
		 */
		public function gfirem_import_form_callback( $attr, $content = null ) {
			GFireMFrontendImportXml::route();
		}
		
		/**
		 * Return an instance of this class.
		 *
		 * @return object A single instance of this class.
		 */
		public static function get_instance() {
			// If the single instance hasn't been set, set it now.
			if ( null === self::$instance ) {
				self::$instance = new self;
			}
			
			return self::$instance;
		}
	}
	add_action( 'plugins_loaded', array( 'GFireMFrontendImport', 'get_instance' ), 1 );
}
