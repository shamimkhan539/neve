<?php
/**
 * Limited offers utility class.
 *
 * Author:          Soare Robert Danial <robert.soare@themeisle.com>
 * Created on:      17/10/2023
 *
 * @package Neve\Core
 */

namespace Neve\Core;

use DateTime;
use DateTimeZone;
use Exception;

/**
 * Class LimitedOffers
 */
class Limited_Offers {

	/**
	 * Active deal.
	 *
	 * @var string
	 */
	private $active = '';

	/**
	 * The banner URL.
	 *
	 * @var string
	 */
	public $banner_url = '';

	/**
	 * The banner URL for customizer
	 *
	 * @var string
	 */
	public $customizer_banner_url = '';

	/**
	 * The key for WP Options to disable the dashboard notification.
	 *
	 * @var string
	 */
	public $wp_option_dismiss_notification_key_base = 'dismiss_themeisle_notice_event_';

	/**
	 * LimitedOffers constructor.
	 */
	public function __construct() {
		try {
			if ( $this->is_deal_active( 'bf' ) ) {
				$this->activate_bff();
				add_filter( 'themeisle_products_deal_priority', [ $this, 'add_priority' ] );
			}
		} catch ( Exception $e ) {
			if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
				error_log( $e->getMessage() ); // phpcs:ignore
			}
		}
	}

	/**
	 * Load hooks for the dashboard.
	 *
	 * @return void
	 */
	public function load_dashboard_hooks() {
		add_action( 'admin_notices', array( $this, 'render_dashboard_banner' ) );
		add_action( 'wp_ajax_dismiss_themeisle_bf_notice', array( $this, 'disable_notification_ajax' ) );
	}

	/**
	 * Check if we have an active deal.
	 *
	 * @return bool True if the deal is active.
	 */
	public function is_active() {
		return ! empty( $this->active );
	}

	/**
	 * Activate the Black Friday deal.
	 *
	 * @return void
	 */
	public function activate_bff() {
		$this->active                = 'bf';
		$this->banner_url            = get_template_directory_uri() . '/assets/img/dashboard/black-friday-banner.png'; // TODO: change this based on product.
		$this->customizer_banner_url = get_template_directory_uri() . '/assets/img/dashboard/black-friday-customizer-banner.png';
	}

	/**
	 * Get the slug of the active deal.
	 *
	 * @return string Active deal.
	 */
	public function get_active_deal() {
		return $this->active;
	}

	/**
	 * Check if the deal is active with the given slug.
	 *
	 * @param string $slug Slug of the deal.
	 *
	 * @throws Exception When date is invalid.
	 */
	public function is_deal_active( $slug ) {

		if ( empty( $slug ) ) {
			return false;
		}

		if ( 'bf' === $slug ) {
			$start_date = '2023-10-10 00:00:00'; // TODO: Add the correct date after QA.
			$end_date   = '2023-11-27 23:59:00';
		} else {
			return false;
		}

		return $this->check_date_range( $start_date, $end_date );
	}

	/**
	 * Get the remaining time for the deal in a human readable format.
	 *
	 * @param string $slug Slug of the deal.
	 * @return string Remaining time for the deal.
	 */
	public function get_remaining_time_for_deal( $slug ) {
		if ( empty( $slug ) ) {
			return '';
		}

		if ( 'bf' === $slug ) {
			$end_date = '2023-11-27 23:59:00';
		} else {
			return '';
		}

		try {
			$end_date     = new DateTime( $end_date, new DateTimeZone( 'GMT' ) );
			$current_date = new DateTime( 'now', new DateTimeZone( 'GMT' ) );
			$diff         = $end_date->diff( $current_date );

			if ( $diff->days > 0 ) {
				return $diff->format( '%a days' );
			}

			if ( $diff->h > 0 ) {
				return $diff->format( '%h hours' );
			}

			if ( $diff->i > 0 ) {
				return $diff->format( '%i minutes' );
			}

			return $diff->format( '%s seconds' );
		} catch ( Exception $e ) {
			if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
				error_log( $e->getMessage() ); // phpcs:ignore
			}
		}

		return '';
	}

	/**
	 * Check if the current date is in the range of the offer.
	 *
	 * @param string $start Start date.
	 * @param string $end   End date.
	 *
	 * @throws Exception When date is invalid.
	 */
	public function check_date_range( $start, $end ) {

		$start_date   = new DateTime( $start, new DateTimeZone( 'GMT' ) );
		$end_date     = new DateTime( $end, new DateTimeZone( 'GMT' ) );
		$current_date = new DateTime( 'now', new DateTimeZone( 'GMT' ) );

		return $start_date <= $current_date && $current_date <= $end_date;
	}

	/**
	 * Get the localized data for the plugin.
	 *
	 * @return array Localized data.
	 */
	public function get_localized_data() {
		return array(
			'active'              => $this->is_active(),
			'dealSlug'            => $this->get_active_deal(),
			'remainingTime'       => $this->get_remaining_time_for_deal( $this->get_active_deal() ),
			'urgencyText'         => 'Hurry Up! Only ' . $this->get_remaining_time_for_deal( $this->get_active_deal() ) . ' left',
			'bannerUrl'           => $this->banner_url,
			'customizerBannerUrl' => $this->customizer_banner_url,
			'linkDashboard'       => tsdk_utmify( 'https://themeisle.com/themes/neve/blackfriday', 'blackfridayltd23', 'dashboard' ), // TODO: change this based on product.
			'linkGlobal'          => tsdk_utmify( 'https://themeisle.com/themes/neve/blackfriday', 'blackfridayltd23', 'globalnotice' ),
			'linkCustomizer'      => tsdk_utmify( 'https://themeisle.com/themes/neve/', 'blackfriday23', 'customizer' ),
		);
	}

	/**
	 * Disable the notification via ajax.
	 *
	 * @return void
	 */
	public function disable_notification_ajax() {
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['nonce'] ), 'dismiss_themeisle_bf_notice' ) ) {
			wp_die( esc_html( __( 'Invalid nonce! Refresh the page and try again.', 'neve' ) ) );
		}

		// We record the time and the plugin of the dismissed notification.
		update_option( $this->wp_option_dismiss_notification_key_base . $this->active, 'neve_' . $this->active . '_' . current_time( 'Y_m_d' ) );
		wp_die( 'success' );
	}

	/**
	 * Render the dashboard banner.
	 *
	 * @return void
	 */
	public function render_dashboard_banner() {

		$message = 'Neve <strong>Black Friday Sale</strong> - Save big with a <strong>Lifetime License</strong> of Neve Agency Plan. <strong>Only 100 licenses</strong>, for a limited time!';

		?>
		<style>
			.themeisle-sale {
				padding: 10px 15px;

				display: flex;
				align-items: center;
			}
			.themeisle-sale svg {
				margin-right: 15px;
			}
			.themeisle-sale a {
				margin-left: 5px;
			}
			.themeisle-sale-error {
				color: red;
			}
		</style>
		<div class="themeisle-sale notice notice-info is-dismissible">
			<div class="notice-dismiss"></div>
			<!--- TODO: change this based on product. -->
			<svg width="24" height="24" viewBox="0 0 61 60" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M0.5 0.198486H61V59.9128H0.5V0.198486ZM25.0305 30.0698V44.2415H17.7858V15.4382C17.7858 15.2989 17.8281 15.2013 17.9129 15.1456C17.9976 15.0899 18.1529 15.1595 18.3789 15.3546L36.4696 30.0698V15.8145H43.7143V44.6596C43.7143 44.8268 43.672 44.9313 43.5872 44.9731C43.5025 45.0149 43.3472 44.9383 43.1212 44.7432L25.0305 30.0698ZM43.7143 48.9127H17.7858V51.2699H43.7143V48.9127Z" fill="#0073AA"/>
			</svg>

			<span>
				<?php echo wp_kses_post( $message ); ?>
			</span>
			<a href="<?php echo esc_url( tsdk_utmify( 'https://themeisle.com/themes/neve/blackfriday', 'blackfridayltd23', 'dashboard' ) ); ?>" target="_blank" rel="external noreferrer noopener">
				<?php esc_html_e( 'Learn more', 'neve' ); ?>
			</a>
			<span class="themeisle-sale-error"></span>
		</div>
		<script type="text/javascript">
			window.document.addEventListener( 'DOMContentLoaded', () => {
				const button = document.querySelector( '.themeisle-sale.notice .notice-dismiss' );
				button?.addEventListener( 'click', e => {
					e.preventDefault();
					fetch('<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>', {
						method: 'POST',
						headers: {
							'Content-Type': 'application/x-www-form-urlencoded'
						},
						body: new URLSearchParams({
							action: 'dismiss_themeisle_bf_notice',
							nonce: '<?php echo esc_attr( wp_create_nonce( 'dismiss_themeisle_bf_notice' ) ); ?>'
						})
					})
						.then(response => response.text())
						.then(response => {
							if ( ! response?.includes( 'success' ) ) {
								document.querySelector( '.themeisle-sale-error' ).innerHTML = response;
								return;
							}

							jQuery( '.themeisle-sale.notice' ).fadeOut()
						})
						.catch(error => {
							console.error( 'Error:', error );
							document.querySelector( '.themeisle-sale-error' ).innerHTML = error;
						});
				});
			});
		</script>
		<?php
	}

	/**
	 * Check if we can show the dashboard banner. Since it is shared between themes, the user need only to dismiss it once.
	 *
	 * @return bool
	 */
	public function can_show_dashboard_banner() {
		return ! get_option( $this->wp_option_dismiss_notification_key_base . $this->active, false ) && $this->has_priority();
	}

	/**
	 * Add priority to the filter.
	 *
	 * @param array $products Registered products.
	 * @return array Array enhanced with Neve priority.
	 */
	public function add_priority( $products ) {
		if ( ! is_array( $products ) ) {
			return [ 'neve' => 0 ];
		}

		$priority['neve'] = 0; // TODO: change this based on product.

		return $priority;
	}

	/**
	 * Check if the current product has priority.
	 *
	 * @return bool True if the current product has priority.
	 */
	public function has_priority() {
		$products = apply_filters( 'themeisle_products_deal_priority', [] );

		if ( empty( $products ) ) {
			return true;
		}

		$highest_priority = array_search( max( $products ), $products );
		return 'neve' === $highest_priority; // TODO: change this based on product.
	}
}
