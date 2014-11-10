<?php
/*
Plugin Name: WooDPD
Plugin URI: http://woodpdplugin.com
Description: DPD cart and purchases for WooCommerce
Author: Cristóbal Carnero Liñán
Author URI: http://woodpdplugin.com
Version: 1.0.0

	Copyright: © 2012 Cristóbal Carnero Liñán (email: info@woodpdplugin.com)
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Check if WooCommerce is active
 */
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	if ( ! class_exists( 'WooDPD' ) ) {

		class WooDPD {
			public function __construct() {
				// called only after woocommerce has finished loading
				add_action( 'woocommerce_init', array( &$this, 'woocommerce_loaded' ) );

				// called after all plugins have loaded
				add_action( 'plugins_loaded', array( &$this, 'plugins_loaded' ) );

				// called just before the woocommerce template functions are included
				add_action( 'init', array( &$this, 'include_template_functions' ), 20 );

				// indicates we are running the admin
				if ( is_admin() ) {
					// Product
					// New field: DPD product ID
					add_action( 'woocommerce_product_options_sku', 'wc_dpd_id_field' ); // Below SKU options
					function wc_dpd_id_field() {
						woocommerce_wp_text_input( array( 'id' => 'dpd_id', 'label' => __( 'DPD product ID', 'woodpd' ) ) );
						woocommerce_wp_text_input( array( 'id' => 'dpd_price_id', 'label' => __( 'DPD product price ID', 'woodpd' ), 'description' => __('Only necessary for "Buy now" buttons.', 'woodpd') ) );
					}

					add_action( 'save_post', 'wc_dpd_id_save_product' );
					function wc_dpd_id_save_product( $product_id ) {
						// If this is a auto save do nothing, we only save when update button is clicked
						if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
							return;
						if ( isset( $_POST['dpd_id'] ) ) {
							if ( empty ( $_POST['dpd_id'] ) || is_numeric( $_POST['dpd_id'] ) )
								update_post_meta( $product_id, 'dpd_id', $_POST['dpd_id'] );
						} else delete_post_meta( $product_id, 'dpd_id' );
						if ( isset( $_POST['dpd_price_id'] ) ) {
							if ( empty ( $_POST['dpd_price_id'] ) || is_numeric( $_POST['dpd_price_id'] ) )
								update_post_meta( $product_id, 'dpd_price_id', $_POST['dpd_price_id'] );
						} else delete_post_meta( $product_id, 'dpd_price_id' );
					}

					// Administration
					add_filter( 'woocommerce_general_settings', 'add_dpd_cart_url' );
					function add_dpd_cart_url( $settings ) {
						$updated_settings = array();

						foreach ( $settings as $section ) {
							// At the bottom of the General Options section

							if ( isset( $section['id'] ) && 'general_options' == $section['id'] &&
								isset( $section['type'] ) && 'sectionend' == $section['type'] ) {
									$updated_settings[] = array(
										'name'     => __( 'DPD Cart URL', 'woodpd' ),
										'desc_tip' => __( 'The URL of the DPD store cart.', 'woodpd' ),
										'id'       => 'woodpd_cart_url',
										'type'     => 'text',
										'css'      => 'min-width:300px;',
										'std'      => '',  // WC < 2.0
										'default'  => '',  // WC >= 2.0
										'desc'     => '.dpdcart.com',
									);

									$updated_settings[] = array(
										'name'     => __( '"Add To Cart" buttons text', 'woodpd' ),
										'desc_tip' => __( 'This text will be shown in all "Add To Cart" buttons.', 'woodpd' ),
										'id'       => 'woodpd_add_to_cart_text',
										'type'     => 'text',
										'css'      => 'min-width:300px;',
										'std'      => __( 'Add To Cart', 'woodpd' ),  // WC < 2.0
										'default'  => __( 'Add To Cart', 'woodpd' ),  // WC >= 2.0
										'desc'     => '',
									);

									$updated_settings[] = array(
										'name'     => __( '"Buy Now" buttons text', 'woodpd' ),
										'desc_tip' => __( 'This text will be shown in all "Buy Now" buttons.', 'woodpd' ),
										'id'       => 'woodpd_buy_now_text',
										'type'     => 'text',
										'css'      => 'min-width:300px;',
										'std'      => __( 'Buy Now', 'woodpd' ),  // WC < 2.0
										'default'  => __( 'Buy Now', 'woodpd' ),  // WC >= 2.0
										'desc'     => '',
									);

									$updated_settings[] = array(
										'name'     => __( '"Read More" buttons text', 'woodpd' ),
										'desc_tip' => __( 'This text will be shown in all "Read More" buttons.', 'woodpd' ),
										'id'       => 'woodpd_read_more_text',
										'type'     => 'text',
										'css'      => 'min-width:300px;',
										'std'      => __( 'Read More', 'woodpd' ),  // WC < 2.0
										'default'  => __( 'Read More', 'woodpd' ),  // WC >= 2.0
										'desc'     => '',
									);

									$updated_settings[] = array(
										'name'     => __( 'Button in "Products" page', 'woodpd' ),
										'desc_tip' => '',
										'id'       => 'woodpd_products_button',
										'type'     => 'select',
										'options' => array(
											'read_more'         => __( 'Read More', 'woodpd' ),
											'add_to_cart'   => __( 'Add To Cart', 'woodpd' ),
											'buy_now'  => __( 'Buy Now', 'woodpd' )
										),
										'css'      => 'min-width:150px;',
										'std'      => 'read_more',  // WC < 2.0
										'default'  => 'read_more',  // WC >= 2.0
										'desc'     => '',
									);

									$updated_settings[] = array(
										'name'     => __( 'Button in "Simple Product" page', 'woodpd' ),
										'desc_tip' => '',
										'id'       => 'woodpd_simple_product_button',
										'type'     => 'select',
										'options' => array(
											'add_to_cart'   => __( 'Add To Cart', 'woodpd' ),
											'buy_now'  => __( 'Buy Now', 'woodpd' )
										),
										'css'      => 'min-width:150px;',
										'std'      => 'add_to_cart',  // WC < 2.0
										'default'  => 'add_to_cart',  // WC >= 2.0
										'desc'     => '',
									);

									$updated_settings[] = array(
										'name'     => __( 'Button after product description', 'woodpd' ),
										'desc_tip' => '',
										'id'       => 'woodpd_after_product_button',
										'type'     => 'select',
										'options' => array(
											'none'   => __( 'None', 'woodpd' ),
											'add_to_cart'   => __( 'Add To Cart', 'woodpd' ),
											'buy_now'  => __( 'Buy Now', 'woodpd' )
										),
										'css'      => 'min-width:150px;',
										'std'      => 'none',  // WC < 2.0
										'default'  => 'none',  // WC >= 2.0
										'desc'     => '',
									);
								}

							$updated_settings[] = $section;
						}

						return $updated_settings;
					}
				}

				// indicates we are being served over ssl
				if ( is_ssl() ) {
					// ...
				}

				// take care of anything else that needs to be done immediately upon plugin instantiation, here in the constructor
			}

			/**
			 * Take care of anything that needs woocommerce to be loaded.
			 * For instance, if you need access to the $woocommerce global
			 */
			public function woocommerce_loaded() {
				// ...
			}

			/**
			 * Take care of anything that needs all plugins to be loaded
			 */
			public function plugins_loaded() {
				load_plugin_textdomain( 'woodpd', false, dirname( plugin_basename( __FILE__ ) ) . '/' );
			}

			/**
			 * Override any of the template functions from woocommerce/woocommerce-template.php
			 * with our own template functions file
			 */
			public function include_template_functions() {
				include( 'woodpd-template.php' );
			}
		}

		// finally instantiate our plugin class and add it to the set of globals
		$GLOBALS['woodpd'] = new WooDPD();

		/**
		* Cart button widget
		*/
		class WooDPD_Cart extends WP_Widget {

			// constructor
			function WooDPD_Cart() {
				parent::WP_Widget(false, $name = __('WooDPD Cart Button', 'woodpd') );
			}

			// widget form creation
			function form($instance) {
				// Check values
				if( $instance) {
					$title = esc_attr($instance['title']);
					$text = esc_attr($instance['text']);
				} else {
					$title = '';
					$text = '';
				}
?>

<p>
<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'wp_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text:', 'wp_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo $text; ?>" />
</p>
<?php
			}

			// widget update
			function update($new_instance, $old_instance) {
				$instance = $old_instance;
				// Fields
				$instance['title'] = strip_tags($new_instance['title']);
				$instance['text'] = strip_tags($new_instance['text']);
				return $instance;
			}

			// widget display
			function widget($args, $instance) {
				extract( $args );
				// these are the widget options
				$title = apply_filters('widget_title', $instance['title']);
				$text = $instance['text'];

				echo $before_widget;
				// Display the widget
				echo '<div class="widget-text wp_widget_plugin_box">';

				// Check if title is set
				if ( $title ) {
					echo $before_title . $title . $after_title;
				}

				$dpd_cart_url = get_option( 'woodpd_cart_url', '' );

				if ( $text ) {
					echo '<a href="https://' . $dpd_cart_url  . '.dpdcart.com/cart/view" class="button">' . $text . '</a>';
				} else {
					echo '<a href="https://' . $dpd_cart_url  . '.dpdcart.com/cart/view" class="button">View Cart</a>';
				}

				echo '</div>';
				echo $after_widget;
			}
		}

		// register widget
		add_action('widgets_init', create_function('', 'return register_widget("WooDPD_Cart");'));
	}
}
