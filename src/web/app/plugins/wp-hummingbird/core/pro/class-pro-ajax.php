<?php
/**
 * Class Pro_AJAX is used to parse ajax actions for the PRO version of the plugin.
 *
 * @since 1.5.0
 * @package Hummingbird\Core\Pro
 */

namespace Hummingbird\Core\Pro;

use Exception;
use Hummingbird\Core\Settings;
use Hummingbird\Core\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Pro_AJAX
 */
class Pro_AJAX {

	/**
	 * Pro_AJAX constructor.
	 */
	public function __construct() {
		// Schedule advanced tools database cleanup.
		add_action( 'wp_ajax_wphb_pro_advanced_db_schedule', array( $this, 'advanced_db_schedule' ) );

		// Add recipient for Performance and Uptime reports.
		add_action( 'wp_ajax_wphb_pro_add_recipient', array( $this, 'add_recipient' ) );
		// Save Performance and Uptime reports settings.
		add_action( 'wp_ajax_wphb_pro_save_report_settings', array( $this, 'save_report_settings' ) );

		// Resend confirmation email.
		add_action( 'wp_ajax_wphb_pro_resend_confirmation', array( $this, 'resend_confirmation' ) );
	}

	/**
	 * Check ajax referer and user caps.
	 *
	 * @since 1.8
	 */
	private function check_permissions() {
		check_ajax_referer( 'wphb-fetch', 'nonce' );

		if ( ! current_user_can( Utils::get_admin_capability() ) ) {
			die();
		}
	}

	/**
	 * Schedule database cleanup.
	 *
	 * @since 1.8
	 */
	public function advanced_db_schedule() {
		$this->check_permissions();

		Modules\Cleanup_Cron::reschedule_cron();

		wp_send_json_success();
	}

	/**
	 * Add recipient.
	 *
	 * @since 1.9.3 Unified for Performance and Uptime reports.
	 */
	public function add_recipient() {
		check_ajax_referer( 'wphb-fetch', 'nonce' );

		if ( ! current_user_can( Utils::get_admin_capability() ) ) {
			wp_send_json_error(
				array(
					'message' => __( 'Current user cannot modify settings.', 'wphb' ),
				)
			);
		}

		// Validate email.
		$email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
		if ( ! is_email( $email ) ) {
			wp_send_json_error(
				array(
					'message' => __( 'Please, insert a valid email.', 'wphb' ),
				)
			);
		}

		// Validate module.
		$available_modules = array( 'performance', 'uptime' );
		if ( ! isset( $_POST['module'] ) || ! in_array( wp_unslash( $_POST['module'] ), $available_modules, true ) ) {
			wp_send_json_error(
				array(
					'message' => __( 'Module not defined.', 'wphb' ),
				)
			);
		}

		$module = sanitize_text_field( wp_unslash( $_POST['module'] ) );

		// Validate setting.
		$available_settings = array( 'reports', 'notifications' );
		if ( ! isset( $_POST['setting'] ) || ! in_array( wp_unslash( $_POST['setting'] ), $available_settings, true ) ) {
			wp_send_json_error(
				array(
					'message' => __( 'Setting not defined.', 'wphb' ),
				)
			);
		}

		$setting = sanitize_text_field( wp_unslash( $_POST['setting'] ) );

		// Validate recipient.
		$reports = Settings::get_setting( $setting, $module );
		foreach ( $reports['recipients'] as $recipient ) {
			if ( $email === $recipient['email'] ) {
				wp_send_json_error(
					array(
						'message' => __( 'Recipient already exists.', 'wphb' ),
					)
				);
			}
		}

		$name = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';

		if ( empty( $name ) ) {
			wp_send_json_error(
				array(
					'message' => __( 'Please, insert a valid name.', 'wphb' ),
				)
			);
		}

		wp_send_json_success(
			array(
				'name'  => $name,
				'email' => $email,
			)
		);
	}

	/**
	 * Save Performance and Uptime reports settings.
	 *
	 * @since 1.9.3 Unified for Performance and Uptime reports.
	 */
	public function save_report_settings() {
		check_ajax_referer( 'wphb-fetch', 'nonce' );

		if ( ! current_user_can( Utils::get_admin_capability() ) ) {
			wp_send_json_error(
				array(
					'message' => __( 'Current user cannot modify settings.', 'wphb' ),
				)
			);
		}

		if ( ! isset( $_POST['data'] ) ) {
			wp_send_json_error(
				array(
					'message' => __( 'Error parsing report data.', 'wphb' ),
				)
			);
		}

		// Validate module.
		$available_modules = array( 'performance', 'uptime' );
		if ( ! isset( $_POST['module'] ) || ! in_array( wp_unslash( $_POST['module'] ), $available_modules, true ) ) {
			wp_send_json_error(
				array(
					'message' => __( 'Module not defined.', 'wphb' ),
				)
			);
		}

		$module = sanitize_text_field( wp_unslash( $_POST['module'] ) );

		// Get the data from ajax.
		parse_str( wp_unslash( $_POST['data'] ), $data );

		$reports = Utils::get_module( $module );
		$options = $reports->get_options();

		$type = isset( $data['threshold'] ) ? 'notifications' : 'reports';

		$options[ $type ]['enabled'] = (bool) $data['scheduled-reports'];

		if ( 'reports' === $type ) {
			$options[ $type ]['frequency'] = (int) $data['report-frequency'];
			if ( 30 === (int) $data['report-frequency'] ) {
				$options[ $type ]['day'] = sanitize_text_field( $data['report-day-month'] );
			} else {
				$options[ $type ]['day'] = sanitize_text_field( $data['report-day'] );
			}
			$options[ $type ]['time'] = sanitize_text_field( $data['report-time'] );

			// Randomize the minutes, so we don't spam the API.
			$email_time               = explode( ':', $options[ $type ]['time'] );
			$email_time[1]            = sprintf( '%02d', wp_rand( 0, 59 ) );
			$options[ $type ]['time'] = implode( ':', $email_time );

			// Update data for performance reports.
			if ( 'performance' === $module ) {
				$options['reports']['type']     = isset( $data['report-type'] ) ? sanitize_key( $data['report-type'] ) : 'desktop';
				$options['reports']['metrics']  = isset( $data['metrics'] ) ? (bool) $data['metrics'] : false;
				$options['reports']['audits']   = isset( $data['audits'] ) ? (bool) $data['audits'] : false;
				$options['reports']['historic'] = isset( $data['field-data'] ) ? (bool) $data['field-data'] : false;
			}

			// Clear last sent time.
			if ( isset( $options[ $type ]['last_sent'] ) ) {
				$options[ $type ]['last_sent'] = '';
			}
		} else {
			$options[ $type ]['threshold'] = (int) $data['threshold'];
		}

		if ( ! isset( $options[ $type ]['recipients'] ) ) {
			$options[ $type ]['recipients'] = array();
		}

		$recipients_updated = false;
		if ( isset( $data['report-recipients'] ) ) {
			$new_recipients = array();
			foreach ( $data['report-recipients'] as $recipient ) {
				$recipient = json_decode( $recipient );

				if ( ! $recipient ) {
					continue;
				}

				// Check if the recipient already exists.
				$emails = array_column( $options[ $type ]['recipients'], 'email' );
				if ( isset( $recipient->email ) && in_array( $recipient->email, $emails, true ) ) {
					$new_recipients[] = (array) $recipient;
					continue;
				}

				$recipients_updated = true;
				$new_recipients[]   = (array) $recipient;
			}
			$options[ $type ]['recipients'] = $new_recipients;
			unset( $new_recipients );
		} else {
			$options[ $type ]['enabled']      = false;
			$options[ $type ]['recipients']   = array();
			$options[ $type ]['recipients'][] = Utils::get_user_for_report();
		}

		if ( 'notifications' === $type && 'uptime' === $module ) {
			try {
				$response = Utils::get_api()->uptime->update_recipients( $options[ $type ]['recipients'] );
			} catch ( Exception $e ) {
				wp_send_json_error(
					array(
						'message' => $e->getMessage(),
					)
				);
			}

			if ( isset( $response ) && is_array( $response ) && ! is_wp_error( $response ) ) {
				$options[ $type ]['recipients'] = json_decode( wp_json_encode( $response ), true ); // Convert to array.
			}
		}

		$reports->update_options( $options );

		// We need to do this at the end, because the settings need to be saved first.
		if ( 'reports' === $type && true === (bool) $options['reports']['enabled'] ) {
			// Reschedule. No need to clear again, as we've just cleared on top.
			$next_scan_time = Modules\Reports::get_scheduled_time( $module, true );
			wp_schedule_single_event( $next_scan_time, "wphb_{$module}_report" );
		}

		$notice = '';
		if ( isset( $data['report-recipients'] ) && (bool) $data['scheduled-reports'] && ! $recipients_updated ) {
			if ( isset( $data['threshold'] ) ) {
				if ( '0' === $data['threshold'] ) {
					$notice = __( 'Your changes have been saved successfully. You will get an instant email notification if your website is down.', 'wphb' );
				} else {
					$notice = sprintf(
						/* translators: %d number of minutes */
						esc_html__( 'Your changes have been saved successfully. You will get an email notification if your website has been down for more than %d minutes.', 'wphb' ),
						absint( $data['threshold'] )
					);
				}

				// To avoid a warning later on.
				$data['report-frequency'] = '';
				$data['report-day']       = '';
			} elseif ( isset( $data['report-frequency'] ) ) {
				$notice = esc_html__( 'Your changes have been saved.', 'wphb' );
			}
		} else {
			// Send a default notice for Uptime and Performance module.
			$notice = esc_html__( 'Your changes have been saved.', 'wphb' );
		}

		$is_pending_list = array();

		$is_pending = false;
		// Only for Uptime notifications.
		if ( 'notifications' === $type && 'uptime' === $module && is_array( $options[ $type ]['recipients'] ) ) {
			$is_pending_list = wp_list_pluck( $options[ $type ]['recipients'], 'is_pending' );
			$is_pending      = in_array( true, $is_pending_list, true );
		}

		// Get the recipient count based on pending recipients.
		$recipient_count = count( $is_pending_list ) - count( array_filter( $is_pending_list ) );

		if ( 'notifications' === $type && 'uptime' === $module ) {
			$recipient_notice = Admin\Pro_Admin::get_notification_message();
			$recipient_notice = ! empty( $recipient_notice['message'] ) ? $recipient_notice['message'] : '';
		} else {
			$recipient_notice = Admin\Pro_Admin::get_reporting_message( ucfirst( $module ), $data['report-frequency'], $data['report-day'], $recipient_count, $options[ $type ]['enabled'] );
		}

		wp_send_json_success(
			array(
				'success'          => true,
				'moduleStatus'     => $options[ $type ]['enabled'],
				'enabled'          => (bool) $data['scheduled-reports'] && $recipients_updated && 'notifications' === $type,
				'notice'           => $notice,
				'recipientPending' => $is_pending,
				'recipientNotice'  => $recipient_notice,
			)
		);
	}

	/**
	 * Resend email confirmation for Uptime notifications.
	 *
	 * @since 2.3.0
	 */
	public function resend_confirmation() {
		check_ajax_referer( 'wphb-fetch', 'nonce' );

		$name  = filter_input( INPUT_POST, 'name', FILTER_SANITIZE_STRING );
		$email = filter_input( INPUT_POST, 'email', FILTER_SANITIZE_EMAIL );

		if ( ! $email ) {
			wp_send_json_error();
		}

		Utils::get_api()->uptime->resend_confirmation( $email );

		wp_send_json_success(
			array(
				'message' => sprintf(
					/* translators: %s - recipient name */
					esc_html__( 'The email is sent to %s for subscription confirmation.', 'wphb' ),
					$name
				),
			)
		);
	}

}