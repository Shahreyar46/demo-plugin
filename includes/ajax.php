<?php
/**
 * Ajax class
 *
 * Manage all ajax related functionality
 *
 * @package ChiliDevs\WCConversation
 */

declare(strict_types=1);
namespace WpCommerz;

class Ajax {

	/**
	 * Load autometically when class initiate
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_save_employee_settings', [ $this, 'save_settings' ], 10 );
	}

	/**
	 * Initializes the Ajax() class
	 *
	 * @since 1.0.0
	 *
	 * Checks for an existing Ajax() instance
	 * and if it doesn't find one, creates it.
	 */
	public static function init() {
		static $instance = false;

		if ( ! $instance ) {
			$instance = new Ajax();
		}

		return $instance;
	}

	/**
	 * Save Settings
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function save_settings() {
		$postdata = wp_unslash( $_POST );
		if ( ! wp_verify_nonce( $postdata['nonce'], 'employee-settings-nonce' ) ) {
			wp_send_json_error( __( 'Invalid nonce', 'employee-settings' ) );
		}

		if ( array_key_exists( 'admin_formdata', $postdata ) ) {
			$formdata = json_decode( $postdata['admin_formdata'], true );
		}

		$employee_array = []; 

        if ( isset( $formdata ) && ! empty( $formdata ) ) {

			foreach ( $formdata as $key => $emp_name ) {
				if ( empty( $emp_name ) ) {
					continue;
				}

				$employee_array[] = [
					'employee_name'  => $emp_name,
				];
			}
			
            update_option( 'settings_all_employee_names', $employee_array ); 
		}

		wp_send_json_success($employee_array );
	  
	}

}
